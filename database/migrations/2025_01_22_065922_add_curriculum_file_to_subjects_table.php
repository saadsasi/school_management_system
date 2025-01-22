<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurriculumFileToSubjectsTable extends Migration
{
    public function up()
    {
        Schema::table('subject', function (Blueprint $table) {
            if (!Schema::hasColumn('subject', 'curriculum_file')) {
                $table->string('curriculum_file')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('subject', function (Blueprint $table) {
            if (Schema::hasColumn('subject', 'curriculum_file')) {
                $table->dropColumn('curriculum_file');
            }
        });
    }
}