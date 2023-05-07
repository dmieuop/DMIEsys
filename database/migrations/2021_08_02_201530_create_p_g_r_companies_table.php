<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('p_g_r_companies', function (Blueprint $table) {
            $table->id();
            $table->string('nic', 15);
            $table->string('position', 50);
            $table->string('employer', 100);
            $table->string('period', 20);
            $table->string('registration_year', 4);
            $table->timestamps();
            $table->foreign('nic')->references('nic')->on('postgraduate_registrations')->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
