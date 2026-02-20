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
            $table->bigInteger('nik')->nullable()->change();
            $table->string('username', 80)->nullable()->change();
            $table->json('phone')->nullable()->change();
            $table->string('pekerjaan', 100)->nullable()->change();
            $table->tinyInteger('anggotaKeluarga')->nullable()->change();
            $table->text('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('nik')->nullable(false)->change();
            $table->string('username', 80)->nullable()->change();
            $table->json('phone')->nullable(false)->change();
            $table->string('pekerjaan', 100)->nullable(false)->change();
            $table->tinyInteger('anggotaKeluarga')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
        });
    }
};
