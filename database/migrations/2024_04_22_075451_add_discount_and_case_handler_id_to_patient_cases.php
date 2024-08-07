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
        Schema::table('patient_cases', function (Blueprint $table) {
            $table->integer('case_handler_id')->after('doctor_id');
            $table->string('discount')->after('fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_cases', function (Blueprint $table) {
            $table->dropColumn('case_handler_id');
            $table->dropColumn('discount');
        });
    }
};
