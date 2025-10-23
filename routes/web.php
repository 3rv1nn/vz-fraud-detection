<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FraudScanIndexController;
use App\Http\Controllers\FraudScanHistoryController;

Route::get('/', [FraudScanIndexController::class, 'index']);
Route::get('/fraud-scan-history', [FraudScanHistoryController::class, 'index']);

Route::get('/fraud-scan', [FraudScanIndexController::class, 'postFraudScan']);