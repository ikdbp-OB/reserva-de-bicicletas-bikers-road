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
    const madridTimeFormatter = new Intl.DateTimeFormat('en-GB', {
        timeZone: 'Europe/Madrid',
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        hourCycle: 'h23',
    });

    function pad(value) {
        return String(value).padStart(2, '0');
    }

    function getMadridTimestamp(date, hour, minute) {
        const dateParts = /^(\d{4})-(\d{2})-(\d{2})$/.exec(date);
        const numericHour = Number(hour);
        const numericMinute = Number(minute);

        if (
            !dateParts ||
            hour === '' ||
            minute === '' ||
            !Number.isInteger(numericHour) ||
            !Number.isInteger(numericMinute) ||
            numericHour < 0 ||
            numericHour > 23 ||
            numericMinute < 0 ||
            numericMinute > 59
        ) {
            return NaN;
        }

        const [, year, month, day] = dateParts;
        const wallTime = Date.UTC(
            Number(year),
            Number(month) - 1,
            Number(day),
            numericHour,
            numericMinute
        );
        let timestamp = wallTime;

        for (let attempt = 0; attempt < 3; attempt++) {
            const parts = Object.fromEntries(
                madridTimeFormatter
                    .formatToParts(new Date(timestamp))
                    .map(({ type, value }) => [type, value])
            );
            const formattedWallTime = Date.UTC(
                Number(parts.year),
                Number(parts.month) - 1,
                Number(parts.day),
                Number(parts.hour),
                Number(parts.minute)
            );

            timestamp = wallTime - (formattedWallTime - timestamp);
        }

        const resolved = Object.fromEntries(
            madridTimeFormatter
                .formatToParts(new Date(timestamp))
                .map(({ type, value }) => [type, value])
        );

        if (
            resolved.year !== year ||
            resolved.month !== month ||
            resolved.day !== day ||
            resolved.hour !== pad(numericHour) ||
            resolved.minute !== pad(numericMinute)
        ) {
            return NaN;
        }

        return timestamp;
    }

    function updateBookingTimes() {
        const startDate = document.getElementById('booking_start_date').value;
        const endDate = document.getElementById('booking_end_date').value;
        const startHour = document.getElementById('start_hour').value;
        const startMinute = document.getElementById('start_minute').value;
        const endHour = document.getElementById('end_hour').value;
        const endMinute = document.getElementById('end_minute').value;

        document.getElementById('start_time').value =
            startDate && startHour !== '' && startMinute !== ''
                ? `${startDate}T${pad(startHour)}:${pad(startMinute)}`
                : '';
        document.getElementById('end_time').value =
            endDate && endHour !== '' && endMinute !== ''
                ? `${endDate}T${pad(endHour)}:${pad(endMinute)}`
                : '';
    }

    function updatePriceEstimate() {
        const startTimestamp = getMadridTimestamp(
            document.getElementById('booking_start_date').value,
            document.getElementById('start_hour').value,
            document.getElementById('start_minute').value
        );
        const endTimestamp = getMadridTimestamp(
            document.getElementById('booking_end_date').value,
            document.getElementById('end_hour').value,
            document.getElementById('end_minute').value
        );
        const durationElement = document.getElementById('booking-duration');
        const durationUnitElement = document.getElementById('booking-duration-unit');
        const totalElement = document.getElementById('booking-total');

        if (
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
        updatePriceEstimate();
    }

    bookingForm.querySelectorAll('[required]').forEach((input) => {
        input.addEventListener('invalid', () => {
            input.setCustomValidity(
                input.validity.valueMissing
                    ? bookingForm.dataset.validationRequired
                    : bookingForm.dataset.validationInvalid
            );
        });
        input.addEventListener('input', () => input.setCustomValidity(''));
    });

    bookingForm.addEventListener('submit', updateBookingForm);
    bookingForm.addEventListener('input', updateBookingForm);
    updateBookingForm();
}