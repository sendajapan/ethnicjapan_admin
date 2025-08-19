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
        Schema::create('purchase_costs', function (Blueprint $table) {
            $table->id();
            $table->string('shipment_id')->nullable();
            $table->string('cost_date')->nullable();
            $table->string('cost_name')->nullable();
            $table->double('cost_amount')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_costs');
    }
};
