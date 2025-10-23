export const showCustomersCardGrid = (show) => {
    const customerCardsGrid = document.querySelector(".customers-card-grid");

    show ? customerCardsGrid.classList.remove("hidden") : customerCardsGrid.classList.add("hidden");
}

export const showLoadingSpinner = (show) => {
    const loadingSpinner = document.querySelector(".loading-spinner");

    show ? loadingSpinner.classList.remove("hidden") : loadingSpinner.classList.add("hidden");
}

export const hideNoResultsText = () => {
    const noResultsText = document.querySelector(".no-results-text");
    noResultsText.classList.add("hidden");
};