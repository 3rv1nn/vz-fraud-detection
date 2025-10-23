<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. 
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customerId')->nullable();
            $table->unsignedBigInteger('fraud_scan_id');
            $table->string('bsn')->nullable();
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->dateTime('dateOfBirth')->nullable();
            $table->string('phoneNumber')->nullable();
            $table->string('email')->nullable();
            $table->string('tag')->nullable();
            $table->text('address')->nullable();
            $table->json('products')->nullable();
            $table->string('ipAddress')->nullable();
            $table->string('iban')->nullable();
            $table->dateTime('lastInvoiceDate')->nullable();
            $table->dateTime('lastLoginDateTime')->nullable();
            $table->boolean('isFraud')->nullable();
            $table->timestamps();
            $table->foreign('fraud_scan_id')
                ->references('id')
                ->on('fraud_scans')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
