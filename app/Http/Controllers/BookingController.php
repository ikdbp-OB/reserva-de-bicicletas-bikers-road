<?php
namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('bike')->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $bookings->load('bike');
        return view('bookings.index', compact('bookings'));
    }

    public function create(Bike $bike)
    {
        if ($bike->status !== 'available') {
            return redirect()->route('bikes.index')->with('error', __('pid_booking_bike_unavailable'));
        }
        return view('bookings.create', compact('bike'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bike_id' => 'required|exists:bikes,id',
            'start_time' => ['required', 'date_format:Y-m-d\TH:i'],
            'end_time' => ['required', 'date_format:Y-m-d\TH:i'],
        ], [
            'bike_id.required' => __('pid_booking_validation_bike_required'),
            'bike_id.exists' => __('pid_booking_validation_bike_exists'),
            'start_time.required' => __('pid_booking_validation_start_required'),
            'start_time.date_format' => __('pid_booking_validation_start_format'),
            'end_time.required' => __('pid_booking_validation_end_required'),
            'end_time.date_format' => __('pid_booking_validation_end_format'),
        ]);

        $bookingTimezone = 'Europe/Madrid';
        $localStartTime = Carbon::parse($validated['start_time'], $bookingTimezone);
        $localEndTime = Carbon::parse($validated['end_time'], $bookingTimezone);

        if ($localStartTime->lt(Carbon::now($bookingTimezone))) {
            return back()->withInput()->withErrors(['start_time' => __('pid_booking_start_must_be_future')]);
        }

        if ($localEndTime->lte($localStartTime)) {
            return back()->withInput()->withErrors(['end_time' => __('pid_booking_end_must_follow_start')]);
        }

        $startTime = $localStartTime->copy()->utc();
        $endTime = $localEndTime->copy()->utc();

        $bike=Bike::findOrFail($validated['bike_id']);

        if ($bike->status !== 'available') {
            return back()->withErrors(['bike_id' => __('pid_booking_bike_unavailable')]);
        }

        $hasOverlap = Booking::where('bike_id', $bike->id)
            ->whereIn('status', ['pending', 'active'])
            ->where(function ($query)use($startTime, $endTime) {
                $query->whereBetween('start_time',[$startTime, $endTime])
                      ->orWhereBetween('end_time', [$startTime, $endTime])
                      ->orWhere(function ($q)use($startTime, $endTime) {
                          $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                      });
            })
            ->exists();

        if ($hasOverlap) {
            return back()->withInput()->withErrors(['start_time' => __('pid_booking_time_overlap')]);
        }

        $hours = $startTime->diffInHours($endTime);
        $hours = $hours > 0 ? $hours : 1;
        $totalCost = $hours * $bike->price_per_hour;

        Booking::create([
            'user_id' => Auth::id(),
            'bike_id' => $bike->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending',
            'total_cost' => $totalCost,
        ]);

        return redirect()->route('bookings.index')->with('success', __('pid_booking_created'));
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, __('pid_booking_view_forbidden'));
        }
        $booking->load('bike');
        return view('bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, __('pid_booking_update_forbidden'));
        }
        if ($booking->status !== 'pending') {
            return back()->with('error', __('pid_booking_cancel_pending_only'));
        }
        $booking->update(['status' => 'cancelled']);
        return redirect()->route('bookings.index')->with('success', __('pid_booking_cancelled'));
    }
}