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
        Schema::create('blog_post_blog_tag', function (Blueprint $table) {
            $table->primary(['blog_post_id', 'blog_tag_id']);
            $table->foreignId('blog_post_id')->constrained()->on('blog_posts');
            $table->foreignId('blog_tag_id')->constrained()->on('blog_tags');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts_blog_tags');
    }
};
