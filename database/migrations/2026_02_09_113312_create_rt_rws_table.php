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
        Schema::create('rt_rws', function (Blueprint $table) {
            $table->uuid('rtRwId')->primary();
            $table->string('nomor', 10);
            $table->integer('kodeProvinsi')->nullable();
            $table->integer('kodeKabupaten')->nullable();
            $table->integer('kodeKecamatan')->nullable();
            $table->bigInteger('kodeKelurahan')->nullable();
            $table->text('alamatDetail')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rt_rws');
    }
};
