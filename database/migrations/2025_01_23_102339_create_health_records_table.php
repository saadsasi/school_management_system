<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('health_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('blood_group', 5)->nullable();
            $table->string('vaccination_name')->nullable();
            $table->date('vaccination_date')->nullable();
            $table->string('allergy_type')->nullable();
            $table->enum('allergy_severity', ['mild', 'moderate', 'severe'])->nullable();
            $table->string('disease_name')->nullable();
            $table->string('disease_medications')->nullable();
            $table->date('visit_date')->nullable();
            $table->string('visit_reason')->nullable();
            $table->string('visit_diagnosis')->nullable();
            $table->string('visit_treatment')->nullable();
            $table->text('medical_condition')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->date('record_date');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('health_records');
    }
}