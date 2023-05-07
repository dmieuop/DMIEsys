<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('assignment_marks', function (Blueprint $table) {
            $table->string('student_id', 6);
            $table->string('assignment_code', 15);
            $table->string('course_id', 15);
            $table->string('course_code', 15);
            $table->integer('mark');
            $table->float('lo_1_ref', 4, 2)->nullable();
            $table->float('lo_2_ref', 4, 2)->nullable();
            $table->float('lo_3_ref', 4, 2)->nullable();
            $table->float('lo_4_ref', 4, 2)->nullable();
            $table->float('lo_5_ref', 4, 2)->nullable();
            $table->float('lo_6_ref', 4, 2)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->primary(['student_id', 'assignment_code', 'course_id']);
            $table->foreign('course_code')->references('course_code')->on('general_courses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('course_id')->references('course_id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('student_id')->references('student_id')->on('students')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('assignment_code')->references('assignment_code')->on('assignments')->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
