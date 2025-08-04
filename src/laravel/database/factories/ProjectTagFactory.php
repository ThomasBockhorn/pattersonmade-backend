<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ProjectTag;

class ProjectTagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectTag::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'tagName' => fake()->sentence(4),
        ];
    }
}
