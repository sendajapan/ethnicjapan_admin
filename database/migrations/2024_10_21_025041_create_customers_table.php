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
            $table->string('customer_name')->unique();
            $table->string('customer_country_name')->nullable();
            $table->string('customer_office_phone')->nullable();
            $table->string('customer_primary_contact_name')->nullable();
            $table->string('customer_primary_contact_email')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('customer_description')->nullable();
            $table->integer('account_id')->nullable();
            $table->timestamps();
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
