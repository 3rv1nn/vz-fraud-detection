<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class FraudScan extends Model {
    protected $table = 'fraud_scans';

    public function customers(): HasMany {
        return $this->hasMany(Customer::class);
    }
}
