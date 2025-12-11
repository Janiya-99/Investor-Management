<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nic')->nullable()->after('email');
            $table->boolean('status')->default(true)->after('password');
            $table->softDeletes()->after('remember_token');
            $table->longText('profile_photo')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nic', 'status', 'profile_photo']);
            $table->dropSoftDeletes();
        });
    }
};
