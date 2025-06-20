<?php

use App\Models\Accounts;
use App\Models\BankAccount;
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
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BankAccount::class)->constrained();
            $table->foreignIdFor(Accounts::class)->constrained();
            $table->date('transaction_date')->nullable();
            $table->double('transaction_amount')->nullable();
            $table->double('bank_charges')->nullable();
            $table->double('final_amount')->nullable();
            $table->double('ex_rate')->nullable();
            $table->double('usd_amount')->nullable();
            $table->string('reference')->nullable();
            $table->string('type')->nullable();
            $table->string('transaction_pdf')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_transactions');
    }
};
