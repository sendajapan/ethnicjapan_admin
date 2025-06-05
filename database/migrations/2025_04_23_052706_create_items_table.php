<?php

use App\Models\Category;
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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name')->nullable();
            $table->string('item_category')->nullable();
            $table->foreignIdFor(Category::class)->constrained();
            $table->string('item_description')->nullable();
            $table->string('item_origin')->nullable();
            $table->string('hts_code')->nullable();
            $table->string('item_photo')->nullable();
            $table->string('organic_certification_jas_exporter_jas')->nullable();
            $table->string('organic_certification_jas_exporter_nop')->nullable();
            $table->string('organic_certification_jas_exporter_cor')->nullable();
            $table->string('organic_certification_jas_exporter_eu')->nullable();
            $table->string('producer_organic_certification_jas')->nullable();
            $table->string('producer_organic_certification_nop')->nullable();
            $table->string('producer_organic_certification_cor')->nullable();
            $table->string('producer_organic_certification_eu')->nullable();
            $table->string('spec_sheet')->nullable();
            $table->string('halal_certification_if_needed')->nullable();
            $table->string('kosher_certification_if_needed')->nullable();
            $table->string('product_flow_chart')->nullable();
            $table->string('fair_trade')->nullable();
            $table->string('rainforest_alliance')->nullable();
            $table->string('security_plan')->nullable();
            $table->string('heavy_metals_declaration')->nullable();
            $table->string('gluten_free')->nullable();
            $table->string('nutrition_chart')->nullable();
            $table->string('non_gmo_declaration')->nullable();
            $table->string('traceability_exercise')->nullable();
            $table->string('vegan_declaration')->nullable();

            $table->string('default_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
