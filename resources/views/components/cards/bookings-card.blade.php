@props(['booking'])
@props(['number'])

<a href="{{ route('bookings.show', $booking->id) }}" class="card card-bookings">
    <div class="card-bookings__image">
        <img class="card-bookings__img" 
             src="{{ asset($booking->bike?->image_url ?? '/images/bikes/orbea-oiz-h30/orbea-oiz-h30.png') }}" 
             alt="{{ $booking->bike?->model ?? 'Bike' }}">
    </div>

    <div class="card-bookings__details">
        <div class="card-bookings__header">
            <h2 class="card-bookings__model">{{ $booking->bike?->model ?? 'Bicicleta no disponible' }}</h2>
            <span class="card-bookings__id">#{{ $number }}</span>
        </div>

        <div class="card-bookings__dates">
            <p class="card-bookings__date">
                <strong>{{ __('pid_booking_date') }}:</strong> 
                {{ $booking->start_time?->timezone('Europe/Madrid')->format('d/m/Y') }}
            </p>
            <p class="card-bookings__date">
                <strong>{{ __('pid_booking_start_time') }}:</strong> 
                {{ $booking->start_time?->timezone('Europe/Madrid')->format('H:i') }}
            </p>
            <p class="card-bookings__date">
                <strong>{{ __('pid_booking_end_time') }}:</strong> 
                {{ $booking->end_time?->timezone('Europe/Madrid')->format('H:i') }}
            </p>
        </div>

        <div class="card-bookings__status">
            <span class="card-bookings__status__label">{{ __('pid_booking_status') }}:</span>
            <span class="card-bookings__status__value {{ strtolower($booking->status) }}">
                @if ($booking->status === 'pending')
                    {{ __('pid_booking_status_pending') }}
                @elseif ($booking->status === 'active')
                    {{ __('pid_booking_status_active') }}
                @elseif ($booking->status === 'cancelled')
                    {{ __('pid_booking_status_cancelled') }}
                @elseif ($booking->status === 'completed')
                    {{ __('pid_booking_status_completed') }}
                @endif
            </span>

        </div>

        <div class="card-bookings__footer">
            <p class="card-bookings__price">{{ $booking->total_cost }}€</p>
            <span class="card-bookings__cta">{{ __('pid_view_details') }} →</span>
        </div>
    </div>
</a>