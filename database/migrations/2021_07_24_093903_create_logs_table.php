<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->longText('action');
            $table->string('state', 10)->default('passed');
            $table->string('user', 50);
            $table->timestamps();
        });
    }
};
