<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('transactions', function (Blueprint $table) {

        if (!Schema::hasColumn('transactions', 'uang_bayar')) {
            $table->integer('uang_bayar')->default(0);
        }

        if (!Schema::hasColumn('transactions', 'kembalian')) {
            $table->integer('kembalian')->default(0);
        }

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};
