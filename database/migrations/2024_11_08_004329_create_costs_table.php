<?php

use App\Enums\Currency;
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
        Schema::create('costs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('e.g, cutting cost, shipping cost');
            $table->boolean('active')->default(false)->comment('0: not active, 1: active');
            $table->decimal('default_cost', 8, 2)->nullable()->default(0);
            $table->enum('currency', array_column(Currency::cases(), 'value'))
                ->nullable()
                ->default(Currency::JPY->value)
                ->comment('JPY, TALA');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costs');
    }
};
