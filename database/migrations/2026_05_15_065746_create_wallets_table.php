<?php
// File: database/migrations/xxxx_xx_xx_create_wallets_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('address')->unique();
            $table->string('chain')->default('eth');
            $table->boolean('verified')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'verified']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};