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
            $table->dropColumn('uuid');
        });
    }

    public function down(): void
    {
        Schema::table('last_fm_global_songs_statistics', function (Blueprint $table): void {
            $table->uuid('uuid')->after('id');
        });
    }
};
