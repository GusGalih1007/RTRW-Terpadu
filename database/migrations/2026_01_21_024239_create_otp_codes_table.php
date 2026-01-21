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
        Schema::create('otp_codes', function (Blueprint $table) {
            $table->uuid('otpId')->primary();
            $table->uuid('userId');
            $table->enum('codeType', ['login', 'register', 'reset_password', 'sensitive_action']);
            $table->string('codeHash');
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('expiresAt');
            $table->timestamp('usedAt')->nullable();
            $table->timestamps();

            $table->index(['userId', 'codeType']);
            $table->foreign('userId')->references('userId')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_codes');
    }
};
