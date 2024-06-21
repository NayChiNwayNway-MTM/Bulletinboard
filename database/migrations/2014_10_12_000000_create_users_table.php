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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->text('password');
            $table->string('profile',255)->default('public/uploads/1718253628.jpg');
            $table->string('type',1)->default(1);
            $table->string('phone',20)->nullable();
            $table->string('address',255)->nullable();
            $table->date('dob')->nullable();
            $table->unsignedBigInteger('created_user_id');
            $table->unsignedBigInteger('updated_user_id');
            $table->integer('deleted_user_id')->nullable();
            $table->datetime('created_at');
            $table->datetime('updated_at');
            $table->datetime('deleted_at')->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('created_user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
        Schema::table('users', function (Blueprint $table) {
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
        Schema::dropIfExists('users');
    }
};
