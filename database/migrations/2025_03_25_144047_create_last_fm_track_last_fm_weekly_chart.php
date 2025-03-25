<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('last_fm_track_last_fm_weekly_chart', function (Blueprint $table) {
            $table->unsignedBigInteger('last_fm_track_id');
            $table->unsignedBigInteger('last_fm_weekly_chart_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('playcount');

            $table->foreign('last_fm_track_id', 'fk_track')
                ->references('id')
                ->on('last_fm_tracks');

            $table->foreign('last_fm_weekly_chart_id', 'fk_weekly_chart')
                ->references('id')
                ->on('last_fm_weekly_charts');

            $table->foreign('user_id', 'fk_user')
                ->references('id')
                ->on('users');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('last_fm_track_last_fm_weekly_chart');
    }
};
