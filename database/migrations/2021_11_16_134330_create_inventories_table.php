<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('item_code', 50)->unique();
            $table->string('item_name', 50);
            $table->date('received_date');
            $table->string('indent_no', 100)->nullable();
            $table->string('supplier_name', 100);
            $table->string('model', 50)->nullable();
            $table->string('serial_number', 50)->nullable();
            $table->text('properties')->nullable();
            $table->integer('book_no');
            $table->integer('folio_no');
            $table->integer('value')->nullable();
            $table->string('budget_allocation', 50)->nullable();
            $table->string('location', 100);
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }
};
