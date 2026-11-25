export function filterBookingsByStatus(bookings, status) {
    if (status === 'all') {
        return [...bookings];
    }

    return bookings.filter((booking) => booking.status === status);
}

if (typeof document !== 'undefined') {
    const statusFilter = document.getElementById('booking-status-filter');
    const bookingsContainer = document.querySelector('.bookings__container');
    const resultsCount = document.getElementById('booking-results-count');
    const filteredEmptyMessage = document.getElementById('bookings-filtered-empty-message');

    if (statusFilter && bookingsContainer && resultsCount && filteredEmptyMessage) {
        const resetButton = document.getElementById('reset-booking-filter');
        const emptyMessage = document.getElementById('bookings-empty-message');
        const bookings = Array.from(bookingsContainer.querySelectorAll('.card-bookings')).map((element) => ({
            element,
            status: element.dataset.status,
        }));

        function updateBookings() {
            const matchingBookings = filterBookingsByStatus(bookings, statusFilter.value);
            const matchingElements = new Set(matchingBookings.map((booking) => booking.element));

            bookings.forEach((booking) => {
                booking.element.hidden = !matchingElements.has(booking.element);
            });

            resultsCount.textContent = String(matchingBookings.length);
            filteredEmptyMessage.hidden = bookings.length === 0 || matchingBookings.length > 0;
            if (emptyMessage) {
                emptyMessage.hidden = bookings.length > 0;
            }
        }

        statusFilter.addEventListener('change', updateBookings);
        resetButton?.addEventListener('click', () => {
            statusFilter.value = 'all';
            updateBookings();
        });
        updateBookings();
    }
}
