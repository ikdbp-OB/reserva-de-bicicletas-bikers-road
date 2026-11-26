export function filterAndSortBikes(bikes, filters) {
    const brandQuery = filters.brand.trim().toLowerCase();
    const modelQuery = filters.model.trim().toLowerCase();
    const maxPrice = filters.maxPrice === '' ? null : Number.parseFloat(filters.maxPrice);

    const matchingBikes = bikes.filter((bike) => {
        const matchesAvailability = !filters.availableOnly || bike.available;
        const matchesBrand = !brandQuery || bike.brand.includes(brandQuery);
        const matchesModel = !modelQuery || bike.model.includes(modelQuery);
        const matchesPrice = maxPrice === null || !Number.isFinite(maxPrice) || bike.price <= maxPrice;

        return matchesAvailability && matchesBrand && matchesModel && matchesPrice;
    });

    if (filters.sortOrder === 'price-ascending') {
        matchingBikes.sort((first, second) => first.price - second.price);
    } else if (filters.sortOrder === 'price-descending') {
        matchingBikes.sort((first, second) => second.price - first.price);
    }

    return matchingBikes;
}
