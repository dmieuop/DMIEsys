<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('external_user_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('category', 10);
            $table->string('from_table', 50);
            $table->string('request_email', 100);
            $table->text('token');
            $table->boolean('validity')->default(1);
            $table->timestamps();
        });
    }
};
