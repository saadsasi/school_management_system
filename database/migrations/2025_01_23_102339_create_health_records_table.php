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
            $table->decimal('height', 5, 2)->nullable(); // الطول بالسنتيمتر
            $table->decimal('weight', 5, 2)->nullable(); // الوزن بالكيلوجرام
            $table->string('blood_group', 5)->nullable(); // فصيلة الدم
            $table->text('allergies')->nullable(); // الحساسية
            $table->text('medical_condition')->nullable(); // الحالة الطبية
            $table->text('medications')->nullable(); // الأدوية الحالية
            $table->text('chronic_diseases')->nullable(); // الأمراض المزمنة
            $table->text('previous_surgeries')->nullable(); // العمليات الجراحية السابقة
            $table->text('emergency_contact')->nullable(); // معلومات الاتصال في حالات الطوارئ
            $table->text('notes')->nullable(); // ملاحظات إضافية
            $table->unsignedBigInteger('created_by'); // من أنشأ السجل
            $table->date('record_date'); // تاريخ السجل
            $table->timestamps();
            $table->softDeletes(); // لحذف السجلات بشكل آمن

            // العلاقات
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('health_records');
    }
}