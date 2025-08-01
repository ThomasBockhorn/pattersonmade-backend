<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Project;
use function Pest\Faker\fake;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('index behaves as expected', function (): void {
    $projects = Project::factory()->count(3)->create();

    $response = get(route('projects.index'));

    $response->assertOk();
    $response->assertJsonStructure([]);
});


test('store uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\ProjectController::class,
        'store',
        \App\Http\Requests\ProjectStoreRequest::class
    );

test('store saves', function (): void {
    $title = fake()->sentence(4);
    $description = fake()->text();
    $link = fake()->word();
    $image = fake()->word();

    $response = post(route('projects.store'), [
        'title' => $title,
        'description' => $description,
        'link' => $link,
        'image' => $image,
    ]);

    $projects = Project::query()
        ->where('title', $title)
        ->where('description', $description)
        ->where('link', $link)
        ->where('image', $image)
        ->get();
    expect($projects)->toHaveCount(1);
    $project = $projects->first();

    $response->assertCreated();
    $response->assertJsonStructure([]);
});


test('show behaves as expected', function (): void {
    $project = Project::factory()->create();

    $response = get(route('projects.show', $project));

    $response->assertOk();
    $response->assertJsonStructure([]);
});


test('update uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\ProjectController::class,
        'update',
        \App\Http\Requests\ProjectUpdateRequest::class
    );

test('update behaves as expected', function (): void {
    $project = Project::factory()->create();
    $title = fake()->sentence(4);
    $description = fake()->text();
    $link = fake()->word();
    $image = fake()->word();

    $response = put(route('projects.update', $project), [
        'title' => $title,
        'description' => $description,
        'link' => $link,
        'image' => $image,
    ]);

    $project->refresh();

    $response->assertOk();
    $response->assertJsonStructure([]);

    expect($title)->toEqual($project->title);
    expect($description)->toEqual($project->description);
    expect($link)->toEqual($project->link);
    expect($image)->toEqual($project->image);
});


test('destroy deletes and responds with', function (): void {
    $project = Project::factory()->create();

    $response = delete(route('projects.destroy', $project));

    $response->assertNoContent();

    assertModelMissing($project);
});
