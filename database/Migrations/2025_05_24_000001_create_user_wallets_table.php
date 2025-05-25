<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('eth_address')->unique();
            $table->text('eth_private_key');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_wallets');
    }
};
