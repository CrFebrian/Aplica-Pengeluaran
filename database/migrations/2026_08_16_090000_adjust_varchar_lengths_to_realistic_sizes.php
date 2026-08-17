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
            $table->string('name', 50)->change();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('name', 50)->change();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->string('title', 50)->change();
        });

        Schema::table('debts', function (Blueprint $table) {
            $table->string('creditor_name', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 255)->change();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('name', 255)->change();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->string('title', 255)->change();
        });

        Schema::table('debts', function (Blueprint $table) {
            $table->string('creditor_name', 255)->change();
        });
    }
};
