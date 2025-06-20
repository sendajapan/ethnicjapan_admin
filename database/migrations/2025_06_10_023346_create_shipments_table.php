<?php

use App\Models\Provider;
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

            $table->foreignIdFor(Provider::class)->constrained();
            $table->string('invoice_number')->nullable();
            $table->string('invoice_date')->nullable();
            $table->string('port_of_loading')->nullable();
            $table->string('port_of_landing')->nullable();
            $table->string('incoterm')->nullable();
            $table->double('freight')->nullable();
            $table->double('insurance')->nullable();
            $table->double('exchange_rate')->nullable();
            $table->double('duties')->nullable();
            $table->double('tax')->nullable();
            $table->double('unpack')->nullable();
            $table->double('transport')->nullable();
            $table->double('penalty')->nullable();
            $table->double('other_fee')->nullable();
            $table->string('container_type')->nullable();
            $table->string('bl_number')->nullable();
            $table->string('shipping_line')->nullable();
            $table->string('vessel')->nullable();
            $table->string('eta')->nullable();
            $table->string('etd')->nullable();
            $table->string('country_of_destination')->nullable();
            $table->string('shipment_comment')->nullable();

            $table->string('commercial_invoice')->nullable();
            $table->string('bl_telex_release')->nullable();
            $table->string('packing_list')->nullable();
            $table->string('origin_certificate')->nullable();
            $table->string('phytosanitary')->nullable();



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
