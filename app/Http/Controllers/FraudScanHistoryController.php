<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FraudScan;

class FraudScanHistoryController extends Controller {

    public function index() {
        $fraudScans = FraudScan::with(['customers' => function ($query) {
            $query->orderBy('isFraud', 'desc');
        }])->orderBy('created_at', 'desc')->get();

        return view('fraud-scan-history', ['fraudScans' => $fraudScans]);
    }
}
