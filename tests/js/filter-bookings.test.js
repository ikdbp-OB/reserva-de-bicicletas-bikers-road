import test from 'node:test';
import assert from 'node:assert/strict';
import { filterBookingsByStatus } from '../../resources/js/filter-bookings.js';

const bookings = [
    { status: 'pending' },
    { status: 'active' },
    { status: 'completed' },
    { status: 'cancelled' },
];

test('filters bookings by each existing status without changing the source list', () => {
    for (const status of ['pending', 'active', 'completed', 'cancelled']) {
        assert.deepEqual(filterBookingsByStatus(bookings, status), [{ status }]);
    }

    assert.equal(bookings.length, 4);
});

test('returns all bookings when the all-status option is selected', () => {
    assert.deepEqual(filterBookingsByStatus(bookings, 'all'), bookings);
});
