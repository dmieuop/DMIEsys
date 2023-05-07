<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('p_g_r_universities', function (Blueprint $table) {
            $table->id();
            $table->string('nic', 15);
            $table->string('degreetype', 30);
            $table->string('university', 100);
            $table->string('year', 4);
            $table->string('specialization', 100)->nullable();
            $table->string('class', 15)->nullable();
            $table->integer('credits')->nullable();
            $table->string('gpa', 4)->nullable();
            $table->boolean('hascetificate');
            $table->string('registration_year', 4);
            $table->timestamps();
            $table->foreign('nic')->references('nic')->on('postgraduate_registrations')->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
