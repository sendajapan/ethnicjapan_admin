<?php

use App\Models\Item;
use App\Models\shipments;
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
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(shipments::class)->constrained();
            $table->string('lot_number')->nullable();
            $table->string('lot_unique')->nullable();
            $table->foreignIdFor(Item::class)->constrained()->nullable();
            $table->string('item_description')->nullable();
            $table->string('package_kg')->nullable();
            $table->string('type_of_package')->nullable();
            $table->string('total_packages')->nullable();
            $table->string('unit')->nullable();
            $table->string('total_qty')->nullable();
            $table->string('price_per_unit')->nullable();
            $table->string('total_price')->nullable();
            $table->string('container_no')->nullable();

            $table->string('manufacture_date')->nullable();
            $table->string('crop_year')->nullable();
            $table->string('shelf_life')->nullable();
            $table->string('best_before')->nullable();
            $table->string('lot_comment')->nullable();

            $table->string('loading_report')->nullable();
            $table->string('loading_date')->nullable();
            $table->string('surveyor_name')->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
