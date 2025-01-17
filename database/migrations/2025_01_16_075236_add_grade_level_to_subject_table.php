<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('subject', function (Blueprint $table) {
            $table->enum('grade_level', [
                'first_primary',
                'second_primary',
                'third_primary',
                'fourth_primary',
                'fifth_primary',
                'sixth_primary',
                'first_preparatory',
                'second_preparatory',
                'third_preparatory'
            ])->after('name');
        });
    }

    public function down()
    {
        Schema::table('subject', function (Blueprint $table) {
            $table->dropColumn('grade_level');
        });
    }
};