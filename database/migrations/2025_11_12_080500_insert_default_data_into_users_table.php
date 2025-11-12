<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->insert([
            [
                'nickname'   => 'AdminUser',
                'mail'       => 'admin@example.com',
                'password'   => Hash::make('admin123'),
                'avatar_url' => 'https://media.istockphoto.com/id/516318760/photo/red-fox-vulpes-vulpes.jpg?s=612x612&w=0&k=20&c=jelfBarPxOUUjhiRWDtXlDMAUJJqUih3nnTo7HI4zx8=',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nickname'   => 'TestUser',
                'mail'       => 'test@example.com',
                'password'   => Hash::make('test123'),
                'avatar_url' => 'https://media.istockphoto.com/id/516318760/photo/red-fox-vulpes-vulpes.jpg?s=612x612&w=0&k=20&c=jelfBarPxOUUjhiRWDtXlDMAUJJqUih3nnTo7HI4zx8=',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')
            ->whereIn('email', ['admin@example.com', 'test@example.com'])
            ->delete();
    }
};
