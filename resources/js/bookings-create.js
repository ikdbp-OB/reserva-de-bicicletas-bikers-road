import { getMadridTimestamp, validateBookingRange } from './booking-validation.js';

const bookingForm = document.getElementById('booking-form');

if (bookingForm) {
    const pricePerHour = Number(bookingForm.dataset.pricePerHour);
    const locale = bookingForm.dataset.locale === 'es' ? 'es-ES' : 'en-GB';
    const numberFormatter = new Intl.NumberFormat(locale, {
        maximumFractionDigits: 2,
    });
    const currencyFormatter = new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: 'EUR',
    });
    const pluralRules = new Intl.PluralRules(locale);
    const startDateInput = document.getElementById('booking_start_date');
    const endDateInput = document.getElementById('booking_end_date');
    const startHourInput = document.getElementById('start_hour');
    const startMinuteInput = document.getElementById('start_minute');
    const endHourInput = document.getElementById('end_hour');
    const endMinuteInput = document.getElementById('end_minute');
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    const durationElement = document.getElementById('booking-duration');
    const durationUnitElement = document.getElementById('booking-duration-unit');
    const totalElement = document.getElementById('booking-total');
    const validationMessage = document.getElementById('booking-range-error');
    const requiredInputs = Array.from(bookingForm.querySelectorAll('[required]'));

    function pad(value) {
        return String(value).padStart(2, '0');
    }

    function getBookingTimestamp(dateInput, hourInput, minuteInput) {
        return getMadridTimestamp(dateInput.value, hourInput.value, minuteInput.value);
    }

    function updateBookingTimes() {
        startTimeInput.value =
            startDateInput.value && startHourInput.value !== '' && startMinuteInput.value !== ''
                ? `${startDateInput.value}T${pad(startHourInput.value)}:${pad(startMinuteInput.value)}`
                : '';
        endTimeInput.value =
            endDateInput.value && endHourInput.value !== '' && endMinuteInput.value !== ''
                ? `${endDateInput.value}T${pad(endHourInput.value)}:${pad(endMinuteInput.value)}`
                : '';
    }

    function clearRangeError() {
        startDateInput.setCustomValidity('');
        endDateInput.setCustomValidity('');
        startDateInput.removeAttribute('aria-invalid');
        endDateInput.removeAttribute('aria-invalid');
        validationMessage.hidden = true;
        validationMessage.textContent = '';
    }

    function validateBookingForm() {
        clearRangeError();

        if (requiredInputs.some((input) => input.value === '')) {
            return null;
        }

        if (requiredInputs.some((input) => !input.validity.valid)) {
            return 'invalid';
        }

        const startTimestamp = getBookingTimestamp(startDateInput, startHourInput, startMinuteInput);
        const endTimestamp = getBookingTimestamp(endDateInput, endHourInput, endMinuteInput);
        const error = validateBookingRange(startTimestamp, endTimestamp);

        if (!error) {
            return null;
        }

        const errorInput = error === 'past' ? startDateInput : endDateInput;
        const message = error === 'past'
            ? bookingForm.dataset.validationPast
            : error === 'order'
                ? bookingForm.dataset.validationOrder
                : bookingForm.dataset.validationInvalid;

        errorInput.setCustomValidity(message);
        errorInput.setAttribute('aria-invalid', 'true');
        validationMessage.textContent = message;
        validationMessage.hidden = false;

        return error;
    }

    function updatePriceEstimate(validationError) {
        const startTimestamp = getBookingTimestamp(startDateInput, startHourInput, startMinuteInput);
        const endTimestamp = getBookingTimestamp(endDateInput, endHourInput, endMinuteInput);

        if (
            validationError ||
            !Number.isFinite(startTimestamp) ||
            !Number.isFinite(endTimestamp) ||
            endTimestamp <= startTimestamp
        ) {
            durationElement.textContent = '—';
            durationUnitElement.textContent = '';
            totalElement.textContent = '—';
            return;
        }

        const hours = Math.max(1, (endTimestamp - startTimestamp) / 3_600_000);
        const total = hours * pricePerHour;
        const durationUnit = pluralRules.select(hours) === 'one'
            ? bookingForm.dataset.hourLabel
            : bookingForm.dataset.hoursLabel;

        durationElement.textContent = numberFormatter.format(hours);
        durationUnitElement.textContent = durationUnit;
        totalElement.textContent = currencyFormatter.format(total);
    }

    function updateBookingForm() {
        updateBookingTimes();
        const validationError = validateBookingForm();

        updatePriceEstimate(validationError);

        return validationError;
    }

    requiredInputs.forEach((input) => {
        input.addEventListener('invalid', () => {
            if (!input.validity.customError) {
                input.setCustomValidity(
                    input.validity.valueMissing
                        ? bookingForm.dataset.validationRequired
                        : bookingForm.dataset.validationInvalid
                );
            }
        });
        input.addEventListener('input', () => input.setCustomValidity(''));
    });

    bookingForm.addEventListener('input', updateBookingForm);
    bookingForm.addEventListener('submit', (event) => {
        if (updateBookingForm() || requiredInputs.some((input) => !input.validity.valid)) {
            event.preventDefault();
            bookingForm.reportValidity();
        }
    });
    updateBookingForm();
}
