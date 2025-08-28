<?php

use App\Models\SaleItem;
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
        Schema::create('lot_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SaleItem::class)->constrained();
            $table->integer('item_id')->nullable();
            $table->string('lot_unique')->nullable();
            $table->string('item_quantity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lot_tracking');
    }
};
