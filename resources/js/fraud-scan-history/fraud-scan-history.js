import { renderCustomerCards } from "../generic/customer-cards.js";

const fraudScanHistoryItems = document.querySelectorAll(".fraud-scan-item");

fraudScanHistoryItems.forEach(fraudScanHistoryItem => {
    fraudScanHistoryItem.addEventListener("click", e => {
        const customers = JSON.parse(fraudScanHistoryItem.dataset.customers);
        renderCustomerCards(customers);
    });
});