import test from 'node:test';
import assert from 'node:assert/strict';
import { filterAndSortBikes } from '../../resources/js/bike-catalog.js';

const bikes = [
    { model: 'Trail One', brand: 'orbea', price: 20, available: true },
    { model: 'Trail Two', brand: 'orbea', price: 15, available: true },
    { model: 'Trail Three', brand: 'orbea', price: 10, available: false },
    { model: 'Road One', brand: 'trek', price: 12, available: true },
];

test('combines availability, brand, model, price, and ascending sort', () => {
    const matchingBikes = filterAndSortBikes(bikes, {
        availableOnly: true,
        brand: ' ORBEA ',
        model: 'trail',
        maxPrice: '20',
        sortOrder: 'price-ascending',
    });

    assert.deepEqual(matchingBikes.map((bike) => bike.price), [15, 20]);
});

test('sorts matching bikes by descending price', () => {
    const matchingBikes = filterAndSortBikes(bikes, {
        availableOnly: false,
        brand: '',
        model: '',
        maxPrice: '',
        sortOrder: 'price-descending',
    });

    assert.deepEqual(matchingBikes.map((bike) => bike.price), [20, 15, 12, 10]);
});

test('returns the original catalog order when filters are reset', () => {
    const matchingBikes = filterAndSortBikes(bikes, {
        availableOnly: false,
        brand: '',
        model: '',
        maxPrice: '',
        sortOrder: '',
    });

    assert.deepEqual(matchingBikes, bikes);
});

test('returns no matches when filters exclude every bike', () => {
    const matchingBikes = filterAndSortBikes(bikes, {
        availableOnly: true,
        brand: 'orbea',
        model: 'trail',
        maxPrice: '0',
        sortOrder: '',
    });

    assert.deepEqual(matchingBikes, []);
});
