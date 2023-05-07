<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('postgraduate_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('nic', 15)->unique();
            $table->string('applied_degree', 100);
            $table->string('degree_cat', 50);
            $table->string('fname', 50);
            $table->string('lname', 50);
            $table->string('fullname', 100);
            $table->string('email', 50);
            $table->string('phone', 20);
            $table->text('address');
            $table->date('birthday');
            $table->string('gender', 10);
            $table->string('employment', 20);
            $table->integer('noofuniversities');
            $table->integer('noofcompanies');
            $table->integer('noofmemberships');
            $table->year('year');
            $table->string('file_path', 80);
            $table->boolean('r1_is_submit')->default(0);
            $table->boolean('r2_is_submit')->default(0);
            $table->string('random_phase', 32);
            $table->string('ip', 50);
            $table->timestamps();
        });
    }
};
