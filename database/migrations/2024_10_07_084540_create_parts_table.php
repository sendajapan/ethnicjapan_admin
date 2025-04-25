<?php

use App\Models\Vehicle;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vehicle::class)->constrained()->cascadeOnDelete();
            $table->foreignId('part_category_id')->constrained('part_categories')->onDelete('cascade');
            $table->foreignId('part_sub_category_id')
                ->nullable()
                ->constrained('part_sub_categories')
                ->onDelete('cascade');
            $table->string('barcode')->unique()->nullable()->default(null);
            $table->integer('quantity')->default(1);
            $table->decimal('price', 8, 2)->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
