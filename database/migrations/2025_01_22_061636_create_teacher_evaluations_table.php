<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_subject_id');
            $table->date('evaluation_date');
            $table->text('notes');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('teacher_subject_id')
                  ->references('id')
                  ->on('teacher_subjects')
                  ->onDelete('cascade');
            
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_evaluations');
    }
}