<?php

declare(strict_types=1);

use App\Models\LastFm\Chart;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            Chart::truncate();
            Schema::table('last_fm_charts', function (Blueprint $table) {

                $table->boolean('completed')->default(false)->after('created_at');

            });
        });
    }

    public function down(): void
    {
        Schema::table('last_fm_charts', function (Blueprint $table) {
            $table->dropColumn('completed');
        });
    }
};
