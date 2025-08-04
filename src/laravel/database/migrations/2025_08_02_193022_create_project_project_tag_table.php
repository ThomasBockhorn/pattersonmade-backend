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
        Schema::create('project_project_tag', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained()->on('projects');
            $table->foreignId('project_tag_id')->constrained()->on('project_tags');
            $table->primary(['project_id', 'project_tag_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_project_tag');
    }
};
