export const renderCustomerCards = (customers) => {      
    const customersGroupedByIban = Object.groupBy(customers, ({ iban }) => iban);
    const customersGroupedByIp = Object.groupBy(customers, ({ ipAddress }) => ipAddress);

    const customerCards = document.querySelectorAll(".customer-card");
    const customerCardsAreRendered = customerCards.length > 0;

    if (customerCardsAreRendered) { 
        customers.forEach((customer, i) => { 
            fillCustomerCard(customerCards[i], customer, customersGroupedByIban, customersGroupedByIp);
        }); 
    }
    else {
        const customerCardTemplate = document.querySelector(".customer-card-template");
        const customersCardGrid = document.querySelector(".customers-card-grid");

        customers.forEach(customer => {
            const customerCardTemplateClone = customerCardTemplate.content.cloneNode(true);
            const customerCard = customerCardTemplateClone.children[0];

            fillCustomerCard(customerCard, customer, customersGroupedByIban, customersGroupedByIp);

            customersCardGrid.appendChild(customerCardTemplateClone);
        });
    }
}

const fillCustomerCard = (customerCard, customer, customersGroupedByIban, customersGroupedByIp) => {
    const customerdateOfBirth = new Date(customer.dateOfBirth);
    const customerAge = calculateCustomerAge(customerdateOfBirth);
    customer.customerAge = customerAge;

    customerCard.querySelector(".customer-id-text").textContent = `#${customer.customerId}`;
    customerCard.querySelector(".customer-name-text").textContent = `${customer.firstName} ${customer.lastName}`;
    
    const fraudAssumptionList = customerCard.querySelector(".fraud-assumption-list");
    const fraudAssumptions = getFraudAssumptions(customer, customersGroupedByIban, customersGroupedByIp);
    const isFraudAssumptionListNotEmpty = fraudAssumptionList.children.length > 0;

    if (isFraudAssumptionListNotEmpty) {
        fraudAssumptionList.innerHTML = "";
    }
    
    fraudAssumptions.forEach((fraudAssumption) => {
        const fraudAssumptionItem = document.createElement("li");  
        fraudAssumptionItem.classList.add("text-xs", "font-bold");
        fraudAssumptionItem.textContent = fraudAssumption;
        fraudAssumptionList.appendChild(fraudAssumptionItem);  
    });
    
    customerCard.querySelector(".customer-age-text").textContent = `${customer.customerAge} years old`;
    customerCard.querySelector(".customer-phone-number-text").textContent = customer.phoneNumber;
    customerCard.querySelector(".customer-iban-text").textContent = customer.iban;
    customerCard.querySelector(".customer-ip-address-text").textContent = customer.ipAddress;

    if (customer.isFraud) {
        customerCard.classList.remove("bg-white");
        customerCard.classList.add("bg-red-100");
    }
    else {
        customerCard.classList.add("bg-white");
        customerCard.classList.remove("bg-red-100");
    }
}

const calculateCustomerAge = (dateOfBirth) => {
    const customerdateOfBirth = new Date(dateOfBirth);
    const currentYear = new Date().getFullYear();

    return currentYear - customerdateOfBirth.getFullYear(); 
}

const getFraudAssumptions = (customer, customersGroupedByIban, customersGroupedByIp) => {
    const customersWithDuplicateIban = customersGroupedByIban[customer.iban];
    const customersWithDuplicateIp = customersGroupedByIp[customer.ipAddress];

    const excludeCustomerFromDuplicateIban = customersWithDuplicateIban
    .filter((c) => customer.customerId !== c.customerId).map(customer => customer.firstName + " " + customer.lastName);

    const excludeCustomerFromDuplicateIp = customersWithDuplicateIp
    .filter((c) => customer.customerId !== c.customerId).map(customer => customer.firstName + " " + customer.lastName);

    let fraudAssumptions = [];
    const dutchCallCode = "+31";
    const customerMinAge = 18;

    const hasDutchPhoneNumber = customer.phoneNumber.startsWith(dutchCallCode);
    const isYoungerThanMinAge = customer.customerAge < customerMinAge;
    const hasDuplicateIban = excludeCustomerFromDuplicateIban.length > 0;
    const hasDuplicateIp = excludeCustomerFromDuplicateIp.length > 0;

    if (!hasDutchPhoneNumber) {
        fraudAssumptions.push(`- ${customer.firstName} does not have a Dutch phone number`);
    } 
    
    if (isYoungerThanMinAge) {
        fraudAssumptions.push(`- ${customer.firstName} is younger than 18 years old`);
    }
    
    if (hasDuplicateIban) {
        fraudAssumptions.push(`- ${customer.firstName} has the same IBAN as ${excludeCustomerFromDuplicateIban.join(", ")}`);
    }
     
    if (hasDuplicateIp) {
        fraudAssumptions.push(`- ${customer.firstName} has the same IP as ${excludeCustomerFromDuplicateIp.join(", ")}`);
    }

    return fraudAssumptions;
}