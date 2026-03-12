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
        Schema::create('iuran_payments', function (Blueprint $table) {
            $table->uuid('iuranPaymentId')->primary();
            $table->uuid('iuranSettingId');
            $table->uuid('paidBy');
            $table->tinyInteger('month');
            $table->smallInteger('year');
            $table->decimal('amount', 15, 2);
            $table->timestamp('paymentDate');
            $table->uuid('staff')->nullable();

            $table->foreign('iuranSettingId')->references('iuranSettingId')->on('iuran_settings')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('paidBy')->references('userId')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('staff')->references('userId')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iuran_payments');
    }
};
