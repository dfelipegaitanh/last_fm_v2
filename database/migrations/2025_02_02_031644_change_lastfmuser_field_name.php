<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('Users', function (Blueprint $table) {
            $table->renameColumn('lastfmUser', 'lastfm_user');

        });
    }

    public function down(): void
    {
        Schema::table('Users', function (Blueprint $table) {
            $table->renameColumn('lastfm_user', 'lastfmUser');
        });
    }
};
