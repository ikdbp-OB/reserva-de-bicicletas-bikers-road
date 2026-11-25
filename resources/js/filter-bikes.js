const availableCheckbox = document.querySelector('.bikes__filters input[name="available"]');
const brandInput = document.getElementById('brand');
const nameInput = document.getElementById('name');
const priceInput = document.getElementById('price');
const bikeCards = document.querySelectorAll('.card-bikes');

function filterBikes() {
    if (!bikeCards.length) return;

    const onlyAvailable = availableCheckbox ? availableCheckbox.checked : false;
    const brandQuery = brandInput ? brandInput.value.trim().toLowerCase() : '';
    const modelQuery = nameInput ? nameInput.value.trim().toLowerCase() : '';
    const maxPrice = priceInput && priceInput.value !== '' ? parseFloat(priceInput.value) : NaN;

    bikeCards.forEach((card) => {
        const isAvailable = card.dataset.available === '1';
        const brand = (card.dataset.brand || '').toLowerCase();
        const model = (card.dataset.model || '').toLowerCase();
        const price = parseFloat(card.dataset.price || '0');

        const matchesAvailable = !onlyAvailable || isAvailable;
        const matchesBrand = !brandQuery || brand.includes(brandQuery);
        const matchesModel = !modelQuery || model.includes(modelQuery);
        const matchesPrice = isNaN(maxPrice) || maxPrice <= 0 || price <= maxPrice;

        card.style.display = (matchesAvailable && matchesBrand && matchesModel && matchesPrice)
            ? ''
            : 'none';
    });
}

if (availableCheckbox) availableCheckbox.addEventListener('change', filterBikes);
if (brandInput) brandInput.addEventListener('input', filterBikes);
if (nameInput) nameInput.addEventListener('input', filterBikes);
if (priceInput) priceInput.addEventListener('input', filterBikes);