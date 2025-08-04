<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\Project;
use App\Models\ProjectTag;
use App\Models\Testimonial;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Testimonial::factory()->count(5)->create();

        //Creating projects and tags for many to many relationship
        $projects = Project::factory()->count(5)->create();
        $projectTags = ProjectTag::factory()->count(3)->create();

        $projects->each(function ($project) use ($projectTags) {
            $project->projectTags()->attach(
                $projectTags->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        $blogPosts = BlogPost::factory()->count(5)->create();
        $blogTags = BlogTag::factory()->count(3)->create();

        $blogPosts->each(function ($blogPost) use ($blogTags) {
            $blogPost->blogTags()->attach(
                $blogTags->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

    }
}
