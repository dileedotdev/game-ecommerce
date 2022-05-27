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
        Schema::create('account_fields', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 125);
            $table->foreignId('account_type_id')->constrained();
            $table->boolean('is_required');
            $table->string('regex')->nullable();
            $table->timestamps();

            /**
             * Permissions affect to account_infos to determine who can view/create/update what.
             */
            $table->boolean('can_create_by_creator')->default(false);
            $table->boolean('can_update_by_creator')->default(false);
            $table->boolean('can_delete_by_creator')->default(false);

            $table->boolean('can_view_by_anyone')->default(false);
            $table->boolean('can_view_by_creator')->default(false);
            $table->boolean('can_view_by_unconfirmed_buyer')->default(false);
            $table->boolean('can_view_by_confirmed_buyer')->default(false);

            $table->unique(['name', 'account_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_fields');
    }
};
