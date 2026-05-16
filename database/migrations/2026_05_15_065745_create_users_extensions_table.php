<?php
// File: database/migrations/xxxx_xx_xx_create_users_extensions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('wallet_address')->nullable()->unique();
            $table->string('referral_code')->unique();
            $table->unsignedBigInteger('total_xp')->default(0);
            $table->unsignedInteger('whitelist_points')->default(0);
            $table->unsignedInteger('mint_allocation')->default(0);
            $table->timestamp('last_checkin_at')->nullable();
            $table->boolean('is_banned')->default(false);
            $table->json('metadata')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_extensions');
    }
};
