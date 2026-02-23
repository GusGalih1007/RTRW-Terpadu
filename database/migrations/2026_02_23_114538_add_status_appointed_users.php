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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', ['pending', 'active', 'inactive', 'rejected'])->default('pending')->afetr('roleId');
            $table->uuid('appointedBy')->nullable()->after('roleVerifiedBy');
            $table->timestamp('appointedAt')->nullable()->after('appointedBy');
            $table->uuid('createdBy')->nullable();

            $table->foreign('appointedBy')->references('userId')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('createdBy')->references('userId')->on('users')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
