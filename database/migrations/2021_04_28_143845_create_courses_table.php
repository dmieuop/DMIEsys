<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->string('course_id', 12)->primary();
            $table->string('course_code', 5);
            $table->string('course_name', 100);
            $table->string('year', 4);
            $table->tinyInteger('semester');
            $table->string('batch', 5);
            $table->string('period', 50);
            $table->string('coordinator', 50);
            $table->string('coordinator_username', 50);
            $table->string('moderator', 50);
            $table->string('moderator_username', 50);
            $table->string('secondexaminer', 50);
            $table->string('secondexaminer_username', 50);
            $table->string('instructorincharge', 50);
            $table->string('instructorincharge_username', 50);
            $table->string('status', 20)->default('Ongoing');
            $table->float('assignmentweight', 4, 2)->default(0);
            $table->float('tutorialweight', 4, 2)->default(0);
            $table->float('quizweight', 4, 2)->default(0);
            $table->float('practicalweight', 4, 2)->default(0);
            $table->float('midexamweight', 4, 2)->default(0);
            $table->float('endexamweight', 4, 2)->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->foreign('course_code')->references('course_code')->on('general_courses')->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
