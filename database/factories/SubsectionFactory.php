<?php

namespace Database\Factories;

use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subsection>
 */
class SubsectionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'section_id' => Section::factory(),
            'parent_id' => null,
            'title' => fake()->sentence(4),
            'order' => fake()->numberBetween(1, 20),
        ];
    }
}
