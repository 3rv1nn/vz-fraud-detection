<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Exceptions\ServiceUnavailableException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use App\Models\Customer;
use App\Models\FraudScan;
use Carbon\Carbon;
use App\Enums\HttpStatus;
use App\Enums\ErrorMessage;

class FraudScanIndexController extends Controller {
    
    public function index() {        
        return view('fraud-scan-index');
    }

    public function postFraudScan() {
        try {
            $response = Http::get('http://localhost:8080/api/v1/customers');

            if ($response->status() === HttpStatus::ServiceUnavailable->value) {
                throw new ServiceUnavailableException();
            }

            $customers = $response->collect('customers');

            $fraudScan = $this->createFraudScan();

            $scannedCustomers = $this->scanCustomersForFraud($fraudScan->id, $customers);

            return $scannedCustomers->sortByDesc('isFraud')->values()->all();
        }
        catch (ServiceUnavailableException $e) {
            return response()->json(['error_message' => ErrorMessage::ServiceUnavailable->value], HttpStatus::ServiceUnavailable->value);
        }
        catch (ConnectionException $e) {
            return response()->json(['error_message' => ErrorMessage::NoConnection->value], HttpStatus::GatewayTimeOut->value);  
        }
    }

    private function createFraudScan(): FraudScan {
        $fraudScan = new FraudScan;

        $fraudScan->save();

        return $fraudScan;
    }

    private function scanCustomersForFraud($fraudScanId, $customers): Collection {
        $ibanDuplicates = $customers->duplicatesStrict('iban')->all();
        $ipDuplicates = $customers->duplicatesStrict('ipAddress')->all();
        $minCustomerAge = 18;

        $frauds = $customers->filter(function ($customer) use ($minCustomerAge, $ibanDuplicates, $ipDuplicates) {
            $customerAge = Carbon::parse($customer['dateOfBirth'])->age;
            $dutchCallCode = '+31';

            return !str_starts_with($customer['phoneNumber'], $dutchCallCode) || 
            $customerAge < $minCustomerAge || in_array($customer['iban'], $ibanDuplicates) || 
            in_array($customer['ipAddress'], $ipDuplicates);
        });

        $fraudIds = $frauds->map(function ($fraud) {
            return $fraud['customerId'];
        })->toArray();;

        $scannedCustomers = collect([]);

        foreach ($customers as $customer) {
            $scannedCustomer = Customer::create([
                'customerId' => $customer['customerId'],
                'fraud_scan_id' => $fraudScanId,
                'bsn' => $customer['bsn'],
                'firstName' => $customer['firstName'],
                'lastName' => $customer['lastName'],
                'dateOfBirth' => $customer['dateOfBirth'],
                'phoneNumber' => $customer['phoneNumber'],
                'email' => $customer['email'],
                'tag' => $customer['tag'],
                'address' => $customer['address'],
                'products' => $customer['products'],
                'ipAddress' => $customer['ipAddress'],
                'iban' => $customer['iban'],
                'lastInvoiceDate' => $customer['lastInvoiceDate'],
                'lastLoginDateTime' => $customer['lastLoginDateTime'],
                'isFraud' => in_array($customer['customerId'], $fraudIds)
            ]);

            $scannedCustomers->push($scannedCustomer);
        }

        return $scannedCustomers;
    }
}