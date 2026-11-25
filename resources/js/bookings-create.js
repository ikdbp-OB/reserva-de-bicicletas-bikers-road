const bookingForm = document.getElementById('booking-form');

if (bookingForm) {
    function pad(value) {
        return String(value).padStart(2, '0');
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

    bookingForm.addEventListener('submit', updateBookingTimes);
    bookingForm.addEventListener('input', updateBookingTimes);
    updateBookingTimes();
}