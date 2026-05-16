<?php
// File: database/migrations/xxxx_xx_xx_create_check_ins_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('checked_in_at');
            $table->timestamps();

            $table->index(['user_id', 'checked_in_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('check_ins');
    }
};