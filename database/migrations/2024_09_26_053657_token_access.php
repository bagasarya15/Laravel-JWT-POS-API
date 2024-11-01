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
        Schema::create('token_access', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->text('token');
            $table->timestamp('expired_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_access');
    }
};
