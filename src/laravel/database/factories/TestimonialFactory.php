<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Testimonial;

class TestimonialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Testimonial::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'title' => fake()->sentence(4),
            'company' => fake()->company(),
            'comment' => fake()->text(),
            'star' => fake()->randomElement(["oneStar","twoStar","threeStar","fourStar","fiveStar"]),
        ];
    }
}
