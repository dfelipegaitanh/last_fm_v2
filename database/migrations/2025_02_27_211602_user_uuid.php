<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function down(): void
    {
        Schema::rename('users', 'Users_');
        Schema::rename('Users_', 'Users');

    }

    public function up(): void
    {

        Schema::rename('Users', 'users_');
        Schema::rename('users_', 'users');

    }
};
