<?php

use App\Models\Part;
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
        Schema::create('part_sale', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Part::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Sale::class)->constrained()->onDelete('cascade');
            $table->integer('quantity_sold');
            $table->decimal('price_at_sale', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part_sale');
    }
};
