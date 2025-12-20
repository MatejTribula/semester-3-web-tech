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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title', 64);
            $table->text('description')->nullable();
            $table->timestamp('upload_date')->nullable();
            $table->timestamp('approval_date')->nullable();
            $table->enum('visibility_setting', ['Public', 'Unlisted', 'Private'])->default('Private');
            $table->text('file_url')->nullable();
            $table->string('wasm_file_name')->nullable();
            $table->integer('wasm_width')->nullable();
            $table->integer('wasm_height')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
