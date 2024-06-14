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
        Schema::create('post_lists', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->string('description');
            $table->integer('status');
            $table->unsignedBigInteger('created_user_id');
            $table->unsignedBigInteger('updated_user_id');
            $table->integer('deleted_user_id')->nullable();
            $table->datetime('created_at');
            $table->datetime('updated_at')->nullable();
            $table->datetime('deleted_at')->nullable();
        });
        Schema::table('post_lists', function (Blueprint $table) {
            $table->foreign('created_user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
        Schema::table('post_lists', function (Blueprint $table) {
            $table->foreign('updated_user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_lists');
    }
};
