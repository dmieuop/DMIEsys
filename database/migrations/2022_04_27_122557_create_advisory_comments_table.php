<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('advisory_comments', function (Blueprint $table) {
            $table->id();
            $table->string('student_id', 50);
            $table->text('comment');
            $table->bigInteger('commented_by');
            $table->boolean('need_hod_attention')->default(0);
            $table->boolean('need_sc_attention')->default(0);
            $table->boolean('handled_by_hod')->default(0);
            $table->boolean('handled_by_sc')->default(0);
            $table->timestamps();
            $table->foreign('student_id')->references('student_id')->on('students')->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
