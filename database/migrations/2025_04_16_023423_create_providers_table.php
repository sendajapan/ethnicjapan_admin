<?php

use App\Models\Countries;
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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('provider_name')->unique();
            $table->string('provider_country_name')->nullable();
            $table->string('provider_company_name')->nullable();
            $table->string('provider_physical_address')->nullable();
            $table->string('provider_pickup_address')->nullable();
            $table->string('provider_remit_address')->nullable();
            $table->string('provider_office_phone')->nullable();
            $table->string('provider_primary_contact_name')->nullable();
            $table->string('provider_primary_contact_email')->nullable();
            $table->string('provider_account_receivable_contact_email')->nullable();
            $table->string('provider_food_safety_contact_email')->nullable();
            $table->string('provider_food_safety_contact_phone')->nullable();
            $table->string('provider_emergency_recall_contact_phone')->nullable();
            $table->string('provider_emergency_recall_contact_email')->nullable();
            $table->string('provider_list_of_products')->nullable();
            $table->string('gfsi_processing_plant_certification_file')->nullable();
            $table->string('gfsi_processing_plant_certification_type')->nullable();
            $table->string('social_certification_smeta')->nullable();
            $table->string('fda_registration')->nullable();
            $table->string('supplier_questionary_sheet')->nullable();
            $table->integer('account_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
