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
        // Check if table exists first
        if (!Schema::hasTable('class_subject')) {
            Schema::create('class_subject', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('class_id');
                $table->unsignedBigInteger('subject_id');
                $table->tinyInteger('status')->default(0)->comment('0: Active, 1: Inactive');
                $table->tinyInteger('is_delete')->default(0)->comment('0: Not Deleted, 1: Deleted');
                $table->unsignedBigInteger('created_by');
                $table->timestamps();
            
                $table->foreign('class_id')->references('id')->on('class');
                $table->foreign('subject_id')->references('id')->on('subject');
                $table->foreign('created_by')->references('id')->on('users');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_subject');
    }
};
