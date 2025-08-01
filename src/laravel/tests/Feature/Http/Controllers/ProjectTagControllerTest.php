<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ProjectTag;
use function Pest\Faker\fake;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('index behaves as expected', function (): void {
    $projectTags = ProjectTag::factory()->count(3)->create();

    $response = get(route('project-tags.index'));

    $response->assertOk();
    $response->assertJsonStructure([]);
});


test('store uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\ProjectTagController::class,
        'store',
        \App\Http\Requests\ProjectTagStoreRequest::class
    );

test('store saves', function (): void {
    $name = fake()->name();

    $response = post(route('project-tags.store'), [
        'name' => $name,
    ]);

    $projectTags = ProjectTag::query()
        ->where('name', $name)
        ->get();
    expect($projectTags)->toHaveCount(1);
    $projectTag = $projectTags->first();

    $response->assertCreated();
    $response->assertJsonStructure([]);
});


test('show behaves as expected', function (): void {
    $projectTag = ProjectTag::factory()->create();

    $response = get(route('project-tags.show', $projectTag));

    $response->assertOk();
    $response->assertJsonStructure([]);
});


test('update uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\ProjectTagController::class,
        'update',
        \App\Http\Requests\ProjectTagUpdateRequest::class
    );

test('update behaves as expected', function (): void {
    $projectTag = ProjectTag::factory()->create();
    $name = fake()->name();

    $response = put(route('project-tags.update', $projectTag), [
        'name' => $name,
    ]);

    $projectTag->refresh();

    $response->assertOk();
    $response->assertJsonStructure([]);

    expect($name)->toEqual($projectTag->name);
});


test('destroy deletes and responds with', function (): void {
    $projectTag = ProjectTag::factory()->create();

    $response = delete(route('project-tags.destroy', $projectTag));

    $response->assertNoContent();

    assertModelMissing($projectTag);
});
