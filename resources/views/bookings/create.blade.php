@extends('layouts.app')

@section('title', 'Reservar')

@section('content')
    <section class="booking-create">
        <h1 class="booking-create__title">Reservar</h1>

        @if ($errors->any())
            <div class="booking-create__errors">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('bookings.store') }}" class="booking-create__form" id="booking-form">
            @csrf
            <input type="hidden" name="bike_id" value="{{ $bike->id }}">
            <input type="hidden" id="start_time" name="start_time" value="{{ old('start_time') }}">
            <input type="hidden" id="end_time" name="end_time" value="{{ old('end_time') }}">

            <div class="booking-create__left">
                <div class="booking-create__section">
                    <h2>Precio</h2>
                    <p>{{ number_format($bike->price_per_hour, 2, '.', '') }}€/Hora</p>
                </div>

                <fieldset class="booking-create__section">
                    <legend>Metodo de pago</legend>
                    <div class="booking-create__payments">
                        <label class="booking-create__payment">
                            <input type="radio" name="payment_method" value="paypal" checked>
                            <span>Paypal</span>
                        </label>
                        <label class="booking-create__payment">
                            <input type="radio" name="payment_method" value="bizum">
                            <span>Bizum</span>
                        </label>
                        <label class="booking-create__payment">
                            <input type="radio" name="payment_method" value="card">
                            <span>Tarjeta</span>
                        </label>
                    </div>
                </fieldset>

                <div class="booking-create__section">
                    <label class="booking-create__label" for="booking_date">Día</label>
                    <input
                        class="booking-create__date"
                        type="date"
                        id="booking_date"
                        value="{{ old('booking_date', now()->format('Y-m-d')) }}"
                        required
                    >
                </div>

                <div class="booking-create__section">
                    <h2>Hora</h2>
                    <div class="booking-create__time-range">
                        <div class="booking-create__time">
                            <span>Hora inicio</span>
                            <div class="booking-create__time-inputs">
                                <input type="number" id="start_hour" min="0" max="23" aria-label="Hora de inicio">
                                <span>-</span>
                                <input type="number" id="start_minute" min="0" max="59" aria-label="Minutos de inicio">
                            </div>
                        </div>
                        <div class="booking-create__time">
                            <span>Hora fin</span>
                            <div class="booking-create__time-inputs">
                                <input type="number" id="end_hour" min="0" max="23" aria-label="Hora de finalización">
                                <span>-</span>
                                <input type="number" id="end_minute" min="0" max="59" aria-label="Minutos de finalización">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="booking-create__right">
                <fieldset class="booking-create__card">
                    <legend>Tarjeta de credito</legend>

                    <label for="card_number">Numero de tarjeta</label>
                    <input
                        type="text"
                        id="card_number"
                        inputmode="numeric"
                        autocomplete="cc-number"
                        placeholder="1234 5678 9012 3456"
                    >

                    <label for="cardholder">Titular de la tarjeta</label>
                    <input
                        type="text"
                        id="cardholder"
                        autocomplete="cc-name"
                        placeholder="Nombre apellido..."
                    >

                    <div class="booking-create__card-row">
                        <div>
                            <label for="expiry">Fecha de caducidad</label>
                            <input type="text" id="expiry" inputmode="numeric" autocomplete="cc-exp" placeholder="MM/YY">
                        </div>
                        <div>
                            <label for="cvc">Codigo CVV</label>
                            <input type="text" id="cvc" inputmode="numeric" autocomplete="cc-csc" placeholder="123">
                        </div>
                    </div>
                </fieldset>

                <button type="submit" class="booking-create__submit">Confirmar</button>
            </div>
        </form>
    </section>

    <script>
        const bookingForm = document.getElementById('booking-form');
        const bookingDate = document.getElementById('booking_date');

        function pad(value) {
            return String(value).padStart(2, '0');
        }

        function updateBookingTimes() {
            const date = bookingDate.value;
            const startHour = pad(document.getElementById('start_hour').value);
            const startMinute = pad(document.getElementById('start_minute').value);
            const endHour = pad(document.getElementById('end_hour').value);
            const endMinute = pad(document.getElementById('end_minute').value);

            document.getElementById('start_time').value = `${date}T${startHour}:${startMinute}`;
            document.getElementById('end_time').value = `${date}T${endHour}:${endMinute}`;
        }

        bookingForm.addEventListener('submit', updateBookingTimes);
        bookingForm.addEventListener('input', updateBookingTimes);
        updateBookingTimes();
    </script>
@endsection
