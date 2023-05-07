<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('p_g_r_memberships', function (Blueprint $table) {
            $table->id();
            $table->string('nic', 15);
            $table->string('organization', 100);
            $table->string('membershipcat', 100);
            $table->string('membershipno', 20);
            $table->boolean('hasproof');
            $table->string('registration_year', 4);
            $table->timestamps();
            $table->foreign('nic')->references('nic')->on('postgraduate_registrations')->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
