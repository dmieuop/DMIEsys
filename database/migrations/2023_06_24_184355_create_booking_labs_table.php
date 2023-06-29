<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_labs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_id');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('from', 10);
            $table->string('name', 100);
            $table->string('email', 50);
            $table->string('phone', 15)->nullable();
            $table->string('department', 200);
            $table->text('notes')->nullable();
            $table->boolean('approved')->default(0);
            $table->boolean('rejected')->default(0);
            $table->unsignedBigInteger('technical_staff')->nullable();
            $table->timestamps();

            $table->foreign('lab_id')->references('id')->on('labs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('technical_staff')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_labs');
    }
};
