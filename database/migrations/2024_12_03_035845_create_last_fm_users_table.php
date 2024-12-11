<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('last_fm_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users');
            $table->string('name');
            $table->boolean('subscriber');
            $table->string('country');
            $table->string('url');
            $table->json('registered');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('last_fm_users');
    }
};
