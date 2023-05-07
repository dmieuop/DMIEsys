<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('general_courses', function (Blueprint $table) {
            $table->string('course_code', 5)->primary();
            $table->string('course_name', 100);
            $table->tinyInteger('credit');
            $table->string('genre', 2);
            $table->float('lo_1', 4, 2)->nullable();
            $table->float('lo_2', 4, 2)->nullable();
            $table->float('lo_3', 4, 2)->nullable();
            $table->float('lo_4', 4, 2)->nullable();
            $table->float('lo_5', 4, 2)->nullable();
            $table->float('lo_6', 4, 2)->nullable();
            $table->tinyInteger('total_los')->default(0);
            $table->tinyInteger('total_assignments')->default(0);
            $table->tinyInteger('total_practicals')->default(0);
            $table->tinyInteger('total_tutorials')->default(0);
            $table->tinyInteger('total_quizzes')->default(0);
            $table->tinyInteger('total_midquestions')->default(0);
            $table->tinyInteger('total_endquestions')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }
};
