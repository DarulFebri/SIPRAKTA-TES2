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
            $table->string('role')->default('mahasiswa'); // Tambahkan kolom 'role' dengan nilai default 'mahasiswa'
            // Anda bisa menambahkan indeks jika sering melakukan query berdasarkan role
            $table->index('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role'); // Hapus kolom 'role' jika migrasi di-rollback
        });
    }
};
