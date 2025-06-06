<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function down(): void
    {
        Schema::table('last_fm_charts', function (Blueprint $table): void {
            $table->boolean('processed');
        });
    }

    public function up(): void
    {
        Schema::table('last_fm_charts', function (Blueprint $table): void {
            $table->dropColumn('processed');
        });
    }
};
