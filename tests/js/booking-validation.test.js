import test from 'node:test';
import assert from 'node:assert/strict';
import { getMadridTimestamp, validateBookingRange } from '../../resources/js/booking-validation.js';

test('converts Madrid local time to UTC across summer time', () => {
    assert.equal(
        getMadridTimestamp('2030-07-15', '10', '30'),
        Date.parse('2030-07-15T08:30:00Z')
    );
});

test('rejects invalid dates, times, and nonexistent daylight-saving times', () => {
    assert.ok(Number.isNaN(getMadridTimestamp('2030-02-31', '10', '30')));
    assert.ok(Number.isNaN(getMadridTimestamp('2030-07-15', '24', '00')));
    assert.ok(Number.isNaN(getMadridTimestamp('2026-03-29', '02', '30')));
});

test('reports missing or invalid timestamps', () => {
    assert.equal(validateBookingRange(NaN, 200), 'invalid');
});

test('rejects start times in the past', () => {
    assert.equal(validateBookingRange(100, 300, 200), 'past');
});

test('rejects equal and reversed booking times', () => {
    assert.equal(validateBookingRange(200, 200, 100), 'order');
    assert.equal(validateBookingRange(300, 200, 100), 'order');
});

test('accepts a future booking with end time after start', () => {
    assert.equal(validateBookingRange(200, 300, 100), null);
});
