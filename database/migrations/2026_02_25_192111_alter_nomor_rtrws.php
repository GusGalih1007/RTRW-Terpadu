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
        Schema::table('rt_rws', function (Blueprint $table) {
            $table->dropColumn(['nomor']);
            $table->string('rt', 3)->after('rtRwId')->nullable();
            $table->string('rw', 3)->after('rt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rt_rws', function (Blueprint $table) {
            $table->string('nomor', 10)->after('rtRwId');
            $table->dropColumn(['rt', 'rw']);
        });
    }
};
