import { postFraudScan } from './post-fraud-scan.js';

const fraudScanButton = document.querySelector(".start-fraud-scan-button");

fraudScanButton.addEventListener("click", async e => {
    await postFraudScan();
});

