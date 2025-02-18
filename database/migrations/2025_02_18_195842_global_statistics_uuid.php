<?php

use App\Models\LastFmGlobalSongsStatistics;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('last_fm_global_songs_statistics', function (Blueprint $table) {
            $table->uuid()->after('id');
        });

        LastFmGlobalSongsStatistics::chunk(100, function ($statistics) {
            foreach ($statistics as $statistic) {
                $statistic->update(['uuid' => (string) Str::uuid()]);
            }
        });

        Schema::table('last_fm_global_songs_statistics', function (Blueprint $table) {
            $table->uuid()->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('last_fm_global_songs_statistics', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
