<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMedicalInfoToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['blood_group', 'height', 'weight', 'allergies', 'medical_condition']);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('blood_group', 10)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->text('allergies')->nullable();
            $table->text('medical_condition')->nullable();
        });
    }
}
