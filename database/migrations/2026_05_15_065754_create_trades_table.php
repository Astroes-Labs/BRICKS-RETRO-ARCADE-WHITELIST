<?php
// File: database/migrations/xxxx_xx_xx_create_trades_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id')->constrained('users');
            $table->foreignId('to_user_id')->constrained('users');
            $table->foreignId('puzzle_fragment_id')->nullable()->constrained();
            $table->unsignedInteger('xp_cost');
            $table->string('status')->default('completed');
            $table->timestamps();

            $table->index(['from_user_id', 'to_user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};