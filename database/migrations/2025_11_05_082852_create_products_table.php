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
            $table->string('Title', 64);
            $table->text('Description')->nullable();
            $table->timestamp('Upload_Date')->nullable();
            $table->timestamp('Approval_Date')->nullable();
            $table->enum('Visibility_Setting', ['Public', 'Unlisted', 'Private'])->default('Private');
            $table->text('File_Url')->nullable();
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
