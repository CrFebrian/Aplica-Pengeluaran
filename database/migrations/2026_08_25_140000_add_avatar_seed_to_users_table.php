<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Kolom avatar_seed dipakai untuk generate foto profil bergaya
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar_seed', 40)->nullable()->after('email');
        });

        // Backfill: user yang sudah terdaftar sebelum kolom ini ada
        DB::table('users')->whereNull('avatar_seed')->select('id', 'email')->orderBy('id')->each(function ($user) {
            DB::table('users')->where('id', $user->id)->update([
                'avatar_seed' => Str::uuid()->toString(),
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar_seed');
        });
    }
};
