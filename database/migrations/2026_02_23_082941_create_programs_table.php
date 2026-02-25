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
        Schema::create('programs', function (Blueprint $table) {
            $table->uuid('programId')->primary();
            $table->uuid('rtRwId');
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->date('startDate');
            $table->date('endDate')->nullable();
            $table->decimal('budget', 15, 2);
            $table->boolean('isFundedByIuran')->default(false);
            $table->uuid('createdBy')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('rtRwId');
            
            $table->foreign('rtRwId')->references('rtRwId')->on('rt_rws')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('createdBy')->references('userId')->on('users')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
