<?php

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
        Schema::create('bill_payments', function (Blueprint $table) {
            $table->id();
            $table->string('bill_id');
            $table->unsignedInteger('patient_id');
            $table->double('amount', 8, 2)->nullable();
            $table->double('paid_amount', 8, 2)->nullable();
            $table->double('due_amount', 8, 2)->nullable();
            $table->datetime('payment_date');
            $table->string('status');
            $table->string('payment_method');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_payments');
    }
};
