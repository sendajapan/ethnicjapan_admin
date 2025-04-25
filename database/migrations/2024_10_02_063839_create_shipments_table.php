<?php

use App\Enums\ShipmentStatus;
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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();

            // Shipment details
            $table->string('booking_id')->nullable();
            $table->string('provider')->nullable();
            $table->string('vessel')->nullable();

            // Shipping information
            $table->date('departure')->nullable();
            $table->string('shipping_port')->nullable();
            $table->string('destination_port')->nullable();
            $table->string('term')->nullable();

            // Financial details
            $table->string('invoice_customer')->nullable();
            $table->double('exchange_rate')->nullable()->default(1);

            // Status
            $table->enum('status', array_column(ShipmentStatus::cases(), 'value'))
                ->nullable()
                ->default(ShipmentStatus::IN_TRANSIT->value);

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
