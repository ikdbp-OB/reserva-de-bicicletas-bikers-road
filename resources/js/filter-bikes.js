import { filterAndSortBikes } from './bike-catalog.js';

const filtersSection = document.querySelector('.bikes__filters');
const bikesContainer = document.querySelector('.bikes__container');
const resultsCount = document.getElementById('bike-results-count');
const filteredEmptyMessage = document.getElementById('bikes-filtered-empty-message');
const availableCheckbox = filtersSection?.querySelector('input[name="available"]');
const brandInput = filtersSection?.querySelector('#brand');
const modelInput = filtersSection?.querySelector('#name');
const maxPriceInput = filtersSection?.querySelector('#price');
const sortInput = document.getElementById('bike-sort');
const resetButton = document.getElementById('reset-bike-filters');

if (
    filtersSection &&
    bikesContainer &&
    resultsCount &&
    filteredEmptyMessage &&
    availableCheckbox &&
    brandInput &&
    modelInput &&
    maxPriceInput &&
    sortInput
) {
    const bikes = Array.from(bikesContainer.querySelectorAll('.card-bikes')).map((element) => ({
        element,
        available: element.dataset.available === '1',
        brand: (element.dataset.brand || '').toLowerCase(),
        model: (element.dataset.model || '').toLowerCase(),
        price: Number.parseFloat(element.dataset.price || '0'),
    }));

    function updateCatalog() {
        const matchingBikes = filterAndSortBikes(bikes, {
            availableOnly: availableCheckbox.checked,
            brand: brandInput.value,
            model: modelInput.value,
            maxPrice: maxPriceInput.value,
            sortOrder: sortInput.value,
        });
        const matchingElements = new Set(matchingBikes.map((bike) => bike.element));

        bikes.forEach((bike) => {
            bike.element.hidden = !matchingElements.has(bike.element);
        });
        [...matchingBikes, ...bikes.filter((bike) => !matchingElements.has(bike.element))]
            .forEach((bike) => bikesContainer.append(bike.element));

        resultsCount.textContent = String(matchingBikes.length);
        filteredEmptyMessage.hidden = bikes.length === 0 || matchingBikes.length > 0;
    }

    availableCheckbox.addEventListener('change', updateCatalog);
    brandInput.addEventListener('input', updateCatalog);
    modelInput.addEventListener('input', updateCatalog);
    maxPriceInput.addEventListener('input', updateCatalog);
    sortInput.addEventListener('change', updateCatalog);
    resetButton?.addEventListener('click', () => {
        availableCheckbox.checked = false;
        brandInput.value = '';
        modelInput.value = '';
        maxPriceInput.value = '';
        sortInput.value = '';
        updateCatalog();
    });

    updateCatalog();
}
