<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('role', 20)->default('member')->index();
        });

        // Bootstrap the first existing account as administrator for initial setup.
        $firstUserId = DB::table('users')->orderBy('id')->value('id');
        if ($firstUserId !== null) {
            DB::table('users')->where('id', $firstUserId)->update(['role' => 'admin']);
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropIndex(['role']);
            $table->dropColumn('role');
        });
    }
};
