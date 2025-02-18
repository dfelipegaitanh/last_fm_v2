<?php

use App\Models\LastFmUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('last_fm_users', function (Blueprint $table) {
            $table->uuid()->after('id');
        });

        LastFmUser::chunk(100, function ($users) {
            foreach ($users as $user) {
                $user->update(['uuid' => Str::uuid()]);
            }
        });

        Schema::table('last_fm_users', function (Blueprint $table) {
            $table->uuid()->unique()->change();
        });

    }

    public function down(): void
    {
        Schema::table('last_fm_users', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
