<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('last_fm_charts', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();

            $table->bigInteger('from_timestamp');
            $table->bigInteger('to_timestamp');
            $table->string('type');
            $table->boolean('processed')->default(false);
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('last_fm_charts');
    }
};
