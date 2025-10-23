<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model {
    protected $table = 'customers';

    protected $fillable = [
        'customerId',
        'fraud_scan_id',
        'bsn',
        'firstName',
        'lastName',
        'dateOfBirth',
        'phoneNumber',
        'email',
        'tag',
        'address',
        'products',
        'ipAddress',
        'iban',
        'lastInvoiceDate',
        'lastLoginDateTime',
        'isFraud',
    ];

    protected function casts(): array {
        return [
            'address' => 'array',
            'products' => 'array',
            'dateOfBirth' => 'datetime',
            'lastInvoiceDate' => 'datetime',
            'lastLoginDateTime' => 'datetime',
            'isFraud' => 'boolean',
        ];
    }

    public function fraudScan(): BelongsTo {
        return $this->belongsTo(FraudScan::class);
    }
}
