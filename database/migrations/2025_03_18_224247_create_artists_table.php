<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function down(): void
    {
        // Primero restauramos la columna artist en tracks
        Schema::table('last_fm_tracks', function (Blueprint $table) {
            $table->dropForeign(['artist_id']);
            $table->dropColumn('artist_id');
            $table->string('artist')->after('name');
        });

        Schema::dropIfExists('last_fm_artists');
    }

    public function up(): void
    {
        Schema::create('last_fm_artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mbid')->nullable();
            $table->string('url');
            $table->timestamps();

            $table->unique('name');
        });

        // Modificar la tabla tracks para usar artist_id
        Schema::table('last_fm_tracks', function (Blueprint $table) {
            // Primero eliminamos la columna artist si existe
            $table->dropColumn('artist');

            // Agregamos la referencia al artista
            $table->foreignId('artist_id')
                ->after('name')
                ->constrained('last_fm_artists')
                ->cascadeOnDelete();
        });
    }
};
