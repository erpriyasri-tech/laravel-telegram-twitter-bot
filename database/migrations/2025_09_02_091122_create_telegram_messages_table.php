<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('telegram_messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('update_id')->unique();
            $table->bigInteger('message_id');
            $table->bigInteger('chat_id');
            $table->string('chat_title')->nullable();
            $table->text('message_text')->nullable();
            $table->json('raw_update')->nullable();
            $table->text('rewritten_text')->nullable();
            $table->boolean('posted_to_x')->default(false);
            $table->timestamp('posted_at')->nullable();
            $table->timestamp('message_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_messages');
    }
};
