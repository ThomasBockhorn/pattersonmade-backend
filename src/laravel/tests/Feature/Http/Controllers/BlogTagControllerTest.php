<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\BlogTag;
use function Pest\Faker\fake;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('index behaves as expected', function (): void {
    $blogTags = BlogTag::factory()->count(3)->create();

    $response = get(route('blog-tags.index'));

    $response->assertOk();
    $response->assertJsonStructure([]);
});


test('store uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\BlogTagController::class,
        'store',
        \App\Http\Requests\BlogTagStoreRequest::class
    );

test('store saves', function (): void {
    $name = fake()->name();

    $response = post(route('blog-tags.store'), [
        'name' => $name,
    ]);

    $blogTags = BlogTag::query()
        ->where('name', $name)
        ->get();
    expect($blogTags)->toHaveCount(1);
    $blogTag = $blogTags->first();

    $response->assertCreated();
    $response->assertJsonStructure([]);
});


test('show behaves as expected', function (): void {
    $blogTag = BlogTag::factory()->create();

    $response = get(route('blog-tags.show', $blogTag));

    $response->assertOk();
    $response->assertJsonStructure([]);
});


test('update uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\BlogTagController::class,
        'update',
        \App\Http\Requests\BlogTagUpdateRequest::class
    );

test('update behaves as expected', function (): void {
    $blogTag = BlogTag::factory()->create();
    $name = fake()->name();

    $response = put(route('blog-tags.update', $blogTag), [
        'name' => $name,
    ]);

    $blogTag->refresh();

    $response->assertOk();
    $response->assertJsonStructure([]);

    expect($name)->toEqual($blogTag->name);
});


test('destroy deletes and responds with', function (): void {
    $blogTag = BlogTag::factory()->create();

    $response = delete(route('blog-tags.destroy', $blogTag));

    $response->assertNoContent();

    assertModelMissing($blogTag);
});
