<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->string('school_address')->nullable();
            $table->string('school_phone')->nullable();
            $table->string('school_email')->nullable();
            $table->string('school_website')->nullable();
            $table->string('school_logo')->nullable();
            $table->timestamps();
        });

        // إضافة البيانات الافتراضية
        DB::table('settings')->insert([
            'id' => 1,
            'school_name' => 'School Management System',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};