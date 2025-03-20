<?php

declare(strict_types=1);

use App\Models\LastFm\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('last_fm_global_songs_statistics', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class);
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
