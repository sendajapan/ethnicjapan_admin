<?php

use App\Models\Shipment;
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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Shipment::class)->constrained()->cascadeOnDelete();
            $table->date('input_date')->nullable();
            $table->string('provider_name')->nullable();
            $table->string('origin_id')->nullable();
            $table->integer('make_id');
            $table->string('make_title');
            $table->string('model_id');
            $table->string('model_title');
            $table->string('grade')->nullable();
            $table->string('chassis_model')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('veh_fuel')->nullable();
            $table->string('veh_trans')->nullable();
            $table->string('veh_traction')->nullable();
            $table->string('veh_km')->nullable();
            $table->string('veh_cc')->nullable();
            $table->year('veh_year')->nullable();
            $table->string('veh_month')->nullable();
            $table->string('veh_color')->nullable();
            $table->string('gross_weight')->nullable();
            $table->string('net_weight')->nullable();
            $table->string('veh_length')->nullable();
            $table->string('veh_height')->nullable();
            $table->string('veh_width')->nullable();
            $table->text('other_info')->nullable();
            $table->string('engine_type')->nullable();
            $table->string('engine_no')->nullable();
            $table->string('purchase_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_parts');
    }
};
