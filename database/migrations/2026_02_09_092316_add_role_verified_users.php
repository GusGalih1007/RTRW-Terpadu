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
            $table->timestamp('roleVerifiedAt')->after('roleId')->nullable();
            $table->uuid('roleVerifiedBy')->after('roleVerifiedAt')->nullable();

            $table->foreign('roleVerifiedBy')->references('userId')->on('users')->onDelete("set null")->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('roleVerifiedBy');
            $table->dropColumn(['roleVerifiedAt', 'roleVerifiedBy']);
        });
    }
};
