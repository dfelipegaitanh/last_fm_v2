<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('last_fm_global_songs_statistics', function (Blueprint $table): void {
            $table->integer('playcount')->change();
            $table->integer('artist_count')->change();
            $table->integer('track_count')->change();
            $table->integer('album_count')->change();
        });
    }
};
