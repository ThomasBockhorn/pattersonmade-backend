<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Testimonial;
use function Pest\Faker\fake;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('index behaves as expected', function (): void {
    $testimonials = Testimonial::factory()->count(3)->create();

    $response = get(route('testimonials.index'));

    $response->assertOk();
    $response->assertJsonStructure([]);
});


test('store uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\TestimonialController::class,
        'store',
        \App\Http\Requests\TestimonialStoreRequest::class
    );

test('store saves', function (): void {
    $name = fake()->name();
    $title = fake()->sentence(4);
    $company = fake()->company();
    $comment = fake()->text();
    $star = fake()->randomElement(['oneStar', 'twoStar', 'threeStar', 'fourStar', 'fiveStar']);

    $response = post(route('testimonials.store'), [
        'name' => $name,
        'title' => $title,
        'company' => $company,
        'comment' => $comment,
        'star' => $star,
    ]);

    $testimonials = Testimonial::query()
        ->where('name', $name)
        ->where('title', $title)
        ->where('company', $company)
        ->where('comment', $comment)
        ->where('star', $star)
        ->get();
    expect($testimonials)->toHaveCount(1);
    $testimonial = $testimonials->first();

    $response->assertCreated();
    $response->assertJsonStructure([]);
});


test('show behaves as expected', function (): void {
    $testimonial = Testimonial::factory()->create();

    $response = get(route('testimonials.show', $testimonial));

    $response->assertOk();
    $response->assertJsonStructure([]);
});


test('update uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\TestimonialController::class,
        'update',
        \App\Http\Requests\TestimonialUpdateRequest::class
    );

test('update behaves as expected', function (): void {
    $testimonial = Testimonial::factory()->create();
    $name = fake()->name();
    $title = fake()->sentence(4);
    $company = fake()->company();
    $comment = fake()->text();
    $star = fake()->randomElement(['oneStar', 'twoStar', 'threeStar', 'fourStar', 'fiveStar']);;

    $response = put(route('testimonials.update', $testimonial), [
        'name' => $name,
        'title' => $title,
        'company' => $company,
        'comment' => $comment,
        'star' => $star,
    ]);

    $testimonial->refresh();

    $response->assertOk();
    $response->assertJsonStructure([]);

    expect($name)->toEqual($testimonial->name);
    expect($title)->toEqual($testimonial->title);
    expect($company)->toEqual($testimonial->company);
    expect($comment)->toEqual($testimonial->comment);
    expect($star)->toEqual($testimonial->star);
});


test('destroy deletes and responds with', function (): void {
    $testimonial = Testimonial::factory()->create();

    $response = delete(route('testimonials.destroy', $testimonial));

    $response->assertNoContent();

    assertModelMissing($testimonial);
});
