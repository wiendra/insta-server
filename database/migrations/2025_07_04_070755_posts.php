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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('caption')->nullablee();
            $table->boolean('enable_comment');
            $table->boolean('enable_like');
            $table->tinyInteger('visibility');
            $table->timestamps();
        });
        Schema::create('post_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->string('image');
            $table->smallInteger('order');
            $table->timestamps();
        });
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->string('comment');
            $table->timestamps();
        });
        Schema::create('post_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
