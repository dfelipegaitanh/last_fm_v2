<?php

use App\Models\LastFmUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('last_fm_global_songs_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(LastFmUser::class)->constrained('last_fm_users');
            $table->string('playcount');
            $table->string('artist_count');
            $table->string('track_count');
            $table->string('album_count');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('last_fm_global_songs_statistics');
    }
};
