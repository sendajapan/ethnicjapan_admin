<?php

use App\Models\item;
use App\Models\Sale;
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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Sale::class)->constrained();
            $table->foreignIdFor(Item::class)->constrained();
            $table->double('item_qty')->nullable();
            $table->string('item_description')->nullable();
            $table->string('item_hts_code')->nullable();
            $table->double('item_unit_price')->nullable();
            $table->double('item_line_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
