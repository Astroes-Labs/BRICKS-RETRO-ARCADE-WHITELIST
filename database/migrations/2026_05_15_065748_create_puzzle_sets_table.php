<?php
// File: database/migrations/xxxx_xx_xx_create_puzzle_sets_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('puzzle_sets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedTinyInteger('rarity')->default(1); // 1-5
            $table->unsignedInteger('whitelist_reward')->default(1);
            $table->unsignedInteger('mint_bonus')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'rarity']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('puzzle_sets');
    }
};