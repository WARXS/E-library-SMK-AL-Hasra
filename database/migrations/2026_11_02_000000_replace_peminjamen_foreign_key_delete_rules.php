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
        Schema::table('peminjamen', function (Blueprint $table) {
            $table->dropForeign(['buku_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('peminjamen', function (Blueprint $table) {
            $table->foreign('buku_id', 'peminjamen_buku_id_foreign')
                ->references('id')
                ->on('bukus')
                ->restrictOnDelete();

            $table->foreign('user_id', 'peminjamen_user_id_foreign')
                ->references('id')
                ->on('users')
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamen', function (Blueprint $table) {
            $table->dropForeign(['buku_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('peminjamen', function (Blueprint $table) {
            $table->foreign('buku_id', 'peminjamen_buku_id_foreign')
                ->references('id')
                ->on('bukus')
                ->cascadeOnDelete();

            $table->foreign('user_id', 'peminjamen_user_id_foreign')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }
};
