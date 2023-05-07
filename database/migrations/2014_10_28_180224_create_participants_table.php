<?php

use Cmgmyr\Messenger\Models\Models;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(Models::table('participants'), function (Blueprint $table) {
            $table->id();
            $table->bigInteger('thread_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamp('last_read')->nullable();
            $table->timestamps();
        });
    }
};
