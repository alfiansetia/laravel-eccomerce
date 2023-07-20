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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->dateTime('date')->useCurrent();
            $table->integer('total');
            $table->integer('ongkir');
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->enum('status', ['waiting', 'on proccess', 'sent', 'done', 'cancel'])->default('waiting');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->string('resi')->nullable();
            $table->string('receipt_name');
            $table->string('receipt_telp');
            $table->string('receipt_address');
            $table->enum('courir', ['pos', 'jne', 'tiki', 'private'])->default('private');
            $table->string('service')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('payment_id')->references('id')->on('payments')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
