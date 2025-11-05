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
        Schema::dropIfExists('users'); // Deletes the old users table

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('Nickname', 100);
            $table->string('Mail', 150)->unique();
            $table->string('password');
            $table->string('AvatarURL')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
