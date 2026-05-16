<?php
// File: database/migrations/xxxx_xx_xx_create_referrals_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('referee_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['referrer_id', 'referee_id']); // Prevent duplicate referrals
            $table->index('referrer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};