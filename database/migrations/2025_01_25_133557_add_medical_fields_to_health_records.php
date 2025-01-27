<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMedicalFieldsToHealthRecords extends Migration
{
    public function up()
    {
        Schema::table('health_records', function (Blueprint $table) {
            $table->json('vaccinations')->nullable()->after('blood_group');
        });
    }

    public function down()
    {
        Schema::table('health_records', function (Blueprint $table) {
            $table->dropColumn('vaccinations');
        });
    }
}