
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamen', function (Blueprint $table) {
            $table->date('tanggal_pengembalian_aktual')->nullable()->after('tanggal_kembali');
        });
    }

    public function down(): void
    {
        Schema::table('peminjamen', function (Blueprint $table) {
            $table->dropColumn('tanggal_pengembalian_aktual');
        });
    }
};
