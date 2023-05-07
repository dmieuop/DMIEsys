<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('mid_exam_questions', function (Blueprint $table) {
            $table->string('mid_question_code', 15);
            $table->string('course_code', 11);
            $table->float('lo_1', 4, 2)->nullable();
            $table->float('lo_2', 4, 2)->nullable();
            $table->float('lo_3', 4, 2)->nullable();
            $table->float('lo_4', 4, 2)->nullable();
            $table->float('lo_5', 4, 2)->nullable();
            $table->float('lo_6', 4, 2)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->primary(['mid_question_code', 'course_code']);
            $table->foreign('course_code')->references('course_code')->on('general_courses')->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
