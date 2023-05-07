<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('model', 50);
            $table->string('brand', 50)->nullable();
            $table->string('mfcountry', 50)->nullable();
            $table->year('year_of_made');
            $table->date('date_of_purchased');
            $table->integer('power_consumption')->nullable();
            $table->unsignedBigInteger('lab_id')->nullable();
            $table->text('description')->nullable();
            $table->boolean('has_maintenances')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->foreign('lab_id')->references('id')->on('labs')->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
