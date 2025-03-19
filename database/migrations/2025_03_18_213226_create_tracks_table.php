<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('last_fm_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('artist');
            $table->string('mbid');
            $table->string('url');
            $table->timestamps();

            $table->index(['name', 'artist']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('last_fm_tracks');
    }
};
