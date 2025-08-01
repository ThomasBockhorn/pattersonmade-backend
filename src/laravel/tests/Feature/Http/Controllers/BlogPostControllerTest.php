<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\BlogPost;
use function Pest\Faker\fake;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('index behaves as expected', function (): void {
    $blogPosts = BlogPost::factory()->count(3)->create();

    $response = get(route('blog-posts.index'));

    $response->assertOk();
    $response->assertJsonStructure([]);
});


test('store uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\BlogPostController::class,
        'store',
        \App\Http\Requests\BlogPostStoreRequest::class
    );

test('store saves', function (): void {
    $title = fake()->sentence(4);
    $description = fake()->text();
    $link = fake()->word();
    $image = fake()->word();

    $response = post(route('blog-posts.store'), [
        'title' => $title,
        'description' => $description,
        'link' => $link,
        'image' => $image,
    ]);

    $blogPosts = BlogPost::query()
        ->where('title', $title)
        ->where('description', $description)
        ->where('link', $link)
        ->where('image', $image)
        ->get();
    expect($blogPosts)->toHaveCount(1);
    $blogPost = $blogPosts->first();

    $response->assertCreated();
    $response->assertJsonStructure([]);
});


test('show behaves as expected', function (): void {
    $blogPost = BlogPost::factory()->create();

    $response = get(route('blog-posts.show', $blogPost));

    $response->assertOk();
    $response->assertJsonStructure([]);
});


test('update uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\BlogPostController::class,
        'update',
        \App\Http\Requests\BlogPostUpdateRequest::class
    );

test('update behaves as expected', function (): void {
    $blogPost = BlogPost::factory()->create();
    $title = fake()->sentence(4);
    $description = fake()->text();
    $link = fake()->word();
    $image = fake()->word();

    $response = put(route('blog-posts.update', $blogPost), [
        'title' => $title,
        'description' => $description,
        'link' => $link,
        'image' => $image,
    ]);

    $blogPost->refresh();

    $response->assertOk();
    $response->assertJsonStructure([]);

    expect($title)->toEqual($blogPost->title);
    expect($description)->toEqual($blogPost->description);
    expect($link)->toEqual($blogPost->link);
    expect($image)->toEqual($blogPost->image);
});


test('destroy deletes and responds with', function (): void {
    $blogPost = BlogPost::factory()->create();

    $response = delete(route('blog-posts.destroy', $blogPost));

    $response->assertNoContent();

    assertModelMissing($blogPost);
});
