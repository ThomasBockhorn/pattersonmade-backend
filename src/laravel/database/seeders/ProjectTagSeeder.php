<?php

namespace Database\Seeders;

use App\Models\ProjectTag;
use Illuminate\Database\Seeder;

class ProjectTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProjectTag::factory()->count(5)->create();
    }
}
