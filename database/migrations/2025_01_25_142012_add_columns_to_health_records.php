<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToHealthRecords extends Migration
{
    public function up()
    {
        Schema::table('health_records', function (Blueprint $table) {
            if (!Schema::hasColumn('health_records', 'vaccination_name')) {
                $table->string('vaccination_name')->nullable();
            }
            if (!Schema::hasColumn('health_records', 'vaccination_date')) {
                $table->date('vaccination_date')->nullable();
            }
            if (!Schema::hasColumn('health_records', 'allergy_type')) {
                $table->string('allergy_type')->nullable();
            }
            if (!Schema::hasColumn('health_records', 'allergy_severity')) {
                $table->enum('allergy_severity', ['mild', 'moderate', 'severe'])->nullable();
            }
            if (!Schema::hasColumn('health_records', 'disease_name')) {
                $table->string('disease_name')->nullable();
            }
            if (!Schema::hasColumn('health_records', 'disease_medications')) {
                $table->string('disease_medications')->nullable();
            }
            if (!Schema::hasColumn('health_records', 'visit_date')) {
                $table->date('visit_date')->nullable();
            }
            if (!Schema::hasColumn('health_records', 'visit_reason')) {
                $table->string('visit_reason')->nullable();
            }
            if (!Schema::hasColumn('health_records', 'visit_diagnosis')) {
                $table->string('visit_diagnosis')->nullable();
            }
            if (!Schema::hasColumn('health_records', 'visit_treatment')) {
                $table->string('visit_treatment')->nullable();
            }
            if (!Schema::hasColumn('health_records', 'medical_condition')) {
                $table->text('medical_condition')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('health_records', function (Blueprint $table) {
            $table->dropColumn([
                'vaccination_name',
                'vaccination_date',
                'allergy_type',
                'allergy_severity',
                'disease_name',
                'disease_medications',
                'visit_date',
                'visit_reason',
                'visit_diagnosis',
                'visit_treatment',
                'medical_condition'
            ]);
        });
    }
}