<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function down(): void
    {
        Schema::table('last_fm_tracks', function (Blueprint $table) {
            $table->dropForeign(['album_id']);
            $table->dropColumn('album_id');
        });

        Schema::dropIfExists('last_fm_albums');
    }

    public function up(): void
    {
        Schema::create('last_fm_albums', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('artist_id')->constrained('last_fm_artists');
            $table->string('mbid')->nullable();
            $table->string('url');
            $table->timestamps();

            $table->unique(['title', 'artist_id']);
        });

        // Agregar la referencia al álbum en la tabla tracks
        Schema::table('last_fm_tracks', function (Blueprint $table) {
            $table->foreignId('album_id')
                ->after('artist_id')
                ->nullable()
                ->constrained('last_fm_albums')
                ->nullOnDelete();
        });
    }
};
