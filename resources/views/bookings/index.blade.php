@extends('layouts.app')

@section('title', __('tid_my_bookings'))

@section('content')
    <h1 class="bookings__title">{{ __('tid_my_bookings') }}</h1>
    <div class="bookings__filters">
        <label for="booking-status-filter">{{ __('pid_bookings_filter_status') }}</label>
        <select id="booking-status-filter" name="status">
            <option value="all">{{ __('pid_bookings_all_statuses') }}</option>
            <option value="pending">{{ __('pid_booking_status_pending') }}</option>
            <option value="active">{{ __('pid_booking_status_active') }}</option>
            <option value="completed">{{ __('pid_booking_status_completed') }}</option>
            <option value="cancelled">{{ __('pid_booking_status_cancelled') }}</option>
        </select>
        <button type="button" id="reset-booking-filter">{{ __('pid_bookings_reset_filter') }}</button>
    </div>
    <p class="bookings__results-count" aria-live="polite">
        {{ __('pid_bookings_results') }}:
        <span id="booking-results-count">{{ $bookings->count() }}</span>
    </p>
    <section class="bookings__container">
        @forelse ($bookings as $booking)
            <x-cards.bookings-card :booking="$booking" :number="$loop->iteration" />
        @empty
            <p id="bookings-empty-message">{{ __('pid_booking_empty') }}</p>
        @endforelse
        <p id="bookings-filtered-empty-message" hidden>{{ __('pid_bookings_no_results') }}</p>
    </section>
@endsection