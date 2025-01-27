<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHealthRecordsTable extends Migration
{
    public function up()
    {
        Schema::table('health_records', function (Blueprint $table) {
            
            // Add new JSON columns
            $table->json('medical_visits')->nullable()->after('chronic_diseases');
        });
    }

    public function down()
    {
        Schema::table('health_records', function (Blueprint $table) {
            // Remove the new columns
            $table->dropColumn(['vaccinations', 'medical_visits']);
            
            // Restore original columns
            $table->text('allergies')->nullable();
            $table->text('chronic_diseases')->nullable();
        });
    }
}