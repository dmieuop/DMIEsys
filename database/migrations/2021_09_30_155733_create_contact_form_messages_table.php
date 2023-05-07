<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contact_form_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('phone', 15);
            $table->string('email', 100);
            $table->text('message');
            $table->string('ip', 50);
            $table->timestamps();
        });
    }
};
