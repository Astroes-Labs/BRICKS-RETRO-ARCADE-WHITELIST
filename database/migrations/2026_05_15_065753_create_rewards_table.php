<?php
// File: database/migrations/xxxx_xx_xx_create_rewards_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->json('data');
            $table->boolean('claimed')->default(false);
            $table->timestamp('claimed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'claimed', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};