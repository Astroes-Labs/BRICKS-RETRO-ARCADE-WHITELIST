<?php
// File: database/migrations/xxxx_xx_xx_create_puzzle_fragments_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('puzzle_fragments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puzzle_set_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->unsignedTinyInteger('number'); // 1 to 7
            $table->string('image')->nullable();
            $table->string('rarity')->default('common');
            $table->timestamps();

            $table->unique(['puzzle_set_id', 'number']);
            $table->index('rarity');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('puzzle_fragments');
    }
};