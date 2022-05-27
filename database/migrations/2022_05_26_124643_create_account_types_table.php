<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_types', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 125);
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreignId('game_id')->constrained();
            $table->foreignId('creator_id')->constrained('users');

            $table->unique(['name', 'game_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_types');
    }
};
