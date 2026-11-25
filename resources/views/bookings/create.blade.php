@extends('layouts.app')

@section('title', __('pid_book'))

@section('content')
    <section class="booking-create">
        <h1 class="booking-create__title">{{ __('pid_book') }}</h1>

        @if ($errors->any())
            <div class="booking-create__errors">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('bookings.store') }}"
            class="booking-create__form"
            id="booking-form"
            data-price-per-hour="{{ $bike->price_per_hour }}"
            data-locale="{{ app()->getLocale() }}"
            data-hour-label="{{ __('pid_booking_hour') }}"
            data-hours-label="{{ __('pid_booking_hours') }}"
            data-validation-required="{{ __('pid_booking_input_required') }}"
            data-validation-invalid="{{ __('pid_booking_input_invalid') }}"
            data-validation-past="{{ __('pid_booking_start_in_past') }}"
            data-validation-order="{{ __('pid_booking_end_before_start') }}"
        >
            @csrf
            <input type="hidden" name="bike_id" value="{{ $bike->id }}">
            <input type="hidden" id="start_time" name="start_time" value="{{ old('start_time') }}">
            <input type="hidden" id="end_time" name="end_time" value="{{ old('end_time') }}">

            <div class="booking-create__left">
                <div class="booking-create__section">
                    <h2>{{ __('pid_price') }}</h2>
                    <p>{{ \Illuminate\Support\Number::currency($bike->price_per_hour, in: 'EUR', locale: app()->getLocale()) }} / {{ __('pid_booking_hour') }}</p>
                </div>

                <fieldset class="booking-create__section">
                    <legend>{{ __('pid_payment_method') }}</legend>
                    <div class="booking-create__payments">
                        <label class="booking-create__payment">
                            <input type="radio" name="payment_method" value="paypal" checked>
                            <span>PayPal</span>
                        </label>
                        <label class="booking-create__payment">
                            <input type="radio" name="payment_method" value="bizum">
                            <span>Bizum</span>
                        </label>
                        <label class="booking-create__payment">
                            <input type="radio" name="payment_method" value="card">
                            <span>{{ __('pid_card') }}</span>
                        </label>
                    </div>
                </fieldset>

                <div class="booking-create__section date__inputs">
                    <div>
                        <label class="booking-create__label" for="booking_start_date">{{ __('pid_booking_start_date') }}</label>
                        <input
                            class="booking-create__date"
                            type="date"
                            id="booking_start_date"
                            name="booking_start_date"
                            value="{{ old('booking_start_date', now('Europe/Madrid')->format('Y-m-d')) }}"
                            required
                        >
                    </div>
                    
                    <div>
                        <label class="booking-create__label" for="booking_end_date">{{ __('pid_booking_end_date') }}</label>
                        <input
                            class="booking-create__date"
                            type="date"
                            id="booking_end_date"
                            name="booking_end_date"
                            value="{{ old('booking_end_date', now('Europe/Madrid')->format('Y-m-d')) }}"
                            required
                        >
                    </div>
                    
                </div>
                <p id="booking-range-error" class="booking-create__validation-message" role="alert" hidden></p>

                <div class="booking-create__section">
                    <h2>{{ __('pid_booking_time') }}</h2>
                    <div class="booking-create__time-range">
                        <div class="booking-create__time">
                            <span>{{ __('pid_booking_start_time') }}</span>
                            <div class="booking-create__time-inputs">
                                <input type="number" id="start_hour" name="start_hour" min="0" max="23" value="{{ old('start_hour') }}" required aria-label="{{ __('pid_booking_start_hour') }}">
                                <span>-</span>
                                <input type="number" id="start_minute" name="start_minute" min="0" max="59" value="{{ old('start_minute') }}" required aria-label="{{ __('pid_booking_start_minute') }}">
                            </div>
                        </div>
                        <div class="booking-create__time">
                            <span>{{ __('pid_booking_end_time') }}</span>
                            <div class="booking-create__time-inputs">
                                <input type="number" id="end_hour" name="end_hour" min="0" max="23" value="{{ old('end_hour') }}" required aria-label="{{ __('pid_booking_end_hour') }}">
                                <span>-</span>
                                <input type="number" id="end_minute" name="end_minute" min="0" max="59" value="{{ old('end_minute') }}" required aria-label="{{ __('pid_booking_end_minute') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="booking-create__right">
                <fieldset class="booking-create__card">
                    <legend>{{ __('pid_credit_card') }}</legend>

                    <label for="card_number">{{ __('pid_card_number') }}</label>
                    <input
                        type="text"
                        id="card_number"
                        inputmode="numeric"
                        autocomplete="cc-number"
                        placeholder="1234 5678 9012 3456"
                    >

                    <label for="cardholder">{{ __('pid_card_holder') }}</label>
                    <input
                        type="text"
                        id="cardholder"
                        autocomplete="cc-name"
                        placeholder="{{ __('pid_name_placeholder') }}"
                    >

                    <div class="booking-create__card-row">
                        <div>
                            <label for="expiry">{{ __('pid_card_expiration') }}</label>
                            <input type="text" id="expiry" inputmode="numeric" autocomplete="cc-exp" placeholder="MM/YY">
                        </div>
                        <div>
                            <label for="cvc">{{ __('pid_card_cvc') }}</label>
                            <input type="text" id="cvc" inputmode="numeric" autocomplete="cc-csc" placeholder="123">
                        </div>
                    </div>
                </fieldset>

                <div class="booking-create__estimate" aria-live="polite">
                    <div class="booking-create__estimate-details">
                        <h2>{{ __('pid_booking_estimated_total') }}</h2>
                        <p>
                            {{ __('pid_booking_estimated_duration') }}:
                            <span id="booking-duration">—</span>
                            <span id="booking-duration-unit"></span>
                        </p>
                    </div>
                    <p class="booking-create__total" id="booking-total">—</p>
                </div>

                <button type="submit" class="booking-create__submit">{{ __('pid_confirm_booking') }}</button>
            </div>
        </form>
    </section>
@endsection
