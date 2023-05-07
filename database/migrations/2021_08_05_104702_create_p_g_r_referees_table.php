<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('p_g_r_referees', function (Blueprint $table) {
            $table->id();
            $table->string('place', 1);
            $table->string('nic', 15);
            $table->string('name', 100);
            $table->string('email', 100);
            $table->text('designation');
            $table->string('token', 100);
            $table->boolean('is_submit')->default(0);
            $table->year('registration_year');
            $table->date('exp_date');
            $table->timestamps();
            $table->foreign('nic')->references('nic')->on('postgraduate_registrations')->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
