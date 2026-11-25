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