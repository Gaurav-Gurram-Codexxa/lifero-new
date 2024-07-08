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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('contact', 20);
            $table->string('address');
            $table->string('city');
            $table->string('state', 20);
            $table->string('pincode', 10);
            $table->text('remarks')->nullable();
            $table->string('disposition')->nullable();
            $table->string('status')->nullable();
            $table->integer('opened_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
