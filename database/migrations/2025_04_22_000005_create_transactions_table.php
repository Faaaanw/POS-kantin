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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_price', 10, 2);
            $table->decimal('paid_amount', 10, 2);
            $table->decimal('change', 10, 2);
            $table->dateTime('transaction_time');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
