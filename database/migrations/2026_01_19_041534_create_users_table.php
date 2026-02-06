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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('userId')->primary(true);
            $table->bigInteger('nik')->unique();
            $table->string('username', 80);
            $table->json('phone');
            $table->string('email')->unique();
            $table->text('password');
            $table->uuid('roleId')->nullable();
            $table->integer('kodeProvinsi')->nullable();
            $table->integer('kodeKabupaten')->nullable();
            $table->integer('kodeKecamatan')->nullable();
            $table->integer('kodeKelurahan')->nullable();
            $table->text('alamatDetail')->nullable();
            $table->string('pekerjaan', 100);
            $table->tinyInteger('anggotaKeluarga');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('roleId')->references('roleId')->on('roles')->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
