<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->string('student_id', 6)->primary();
            $table->string('name', 50);
            $table->string('email', 50);
            $table->string('phone', 15)->nullable();
            $table->string('batch', 10);
            $table->boolean('graduated')->default(0);
            $table->text('profile_link')->nullable();
            $table->text('current_working')->nullable();
            $table->boolean('hasMarks')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }
};
