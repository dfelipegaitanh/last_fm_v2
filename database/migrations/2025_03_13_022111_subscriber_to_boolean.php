<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function down(): void
    {
        Schema::table('last_fm_users', function (Blueprint $table) {
            $table->string('subscriber')->change();
        });
    }

    public function up(): void
    {
        Schema::table('last_fm_users', function (Blueprint $table) {
            $table->boolean('subscriber')
                ->default(false)
                ->change();
        });
    }
};
