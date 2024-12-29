<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->string('user_type')->after('user_id');
            $table->string('type')->after('user_type');
            $table->date('date')->after('type');
            $table->time('time')->after('date');
            $table->text('reason')->after('time');
            $table->tinyInteger('status')->default(0)->after('reason');
            $table->unsignedBigInteger('created_by')->after('status');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropForeign(['user_id', 'created_by']);
            $table->dropColumn(['user_id', 'user_type', 'type', 'date', 'time', 'reason', 'status', 'created_by']);
        });
    }
};