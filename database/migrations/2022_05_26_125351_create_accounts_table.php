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
        Schema::create('accounts', function (Blueprint $table): void {
            $table->id();
            $table->string('description')->nullable();
            $table->timestamp('confirmed_at')->nullable(); // timestamp of the confirmed by buyer
            $table->timestamps();

            $table->foreignId('account_type_id')->constrained();
            $table->foreignId('creator_id')->constrained('users');
            $table->foreignId('buyer_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
