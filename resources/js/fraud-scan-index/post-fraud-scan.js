import { showCustomersCardGrid, hideNoResultsText, showLoadingSpinner } from "../generic/visibility-helpers.js";
import { renderCustomerCards } from "../generic/customer-cards.js";

export const postFraudScan = async () => {    
    resetCustomersContainerState();
    showLoadingSpinner(true);

    const response = await fetch("/fraud-scan", {method: "GET"});

    const json = await response.json();
        
    if (response.ok) {
        showLoadingSpinner(false);
        renderCustomerCards(json);
        showCustomersCardGrid(true);
    } 
    else {
        showLoadingSpinner(false);
        const errorMessage = document.querySelector(".error-message");
        errorMessage.textContent = json.error_message;
        console.error(json.error_message);
    }
}

const resetCustomersContainerState = () => {
    const errorMessage = document.querySelector(".error-message");
    const isErrorMessageTextEmpty = errorMessage.innerHTML.length === 0;

    const customerCards = document.querySelectorAll(".customer-card");
    const customerCardsAreRendered = customerCards.length > 0;

    if (!isErrorMessageTextEmpty) errorMessage.innerHTML = "";
    
    if (customerCardsAreRendered) {
        showCustomersCardGrid(false);
    }
    
    hideNoResultsText();
};