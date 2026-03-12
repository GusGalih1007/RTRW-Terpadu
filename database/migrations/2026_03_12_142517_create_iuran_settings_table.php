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
        Schema::create('iuran_settings', function (Blueprint $table) {
            $table->uuid('iuranSettingId')->primary();
            $table->uuid('rtRwId');
            $table->decimal('amount', 15, 2);
            $table->date('startDate');
            $table->date('endDate')->nullable();
            $table->boolean('isActive')->default(true);
            $table->uuid('createdBy')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('rtRwId')->references('rtRwId')->on('rt_rws')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('createdBy')->references('userId')->on('users')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iuran_settings');
    }
};
