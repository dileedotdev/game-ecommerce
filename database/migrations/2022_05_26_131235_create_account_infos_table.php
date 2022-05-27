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
        Schema::create('account_infos', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('account_id')->constrained();
            $table->foreignId('account_field_id')->constrained();
            $table->string('value');
            $table->timestamps();

            $table->unique(['account_id', 'account_field_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_infos');
    }
};
