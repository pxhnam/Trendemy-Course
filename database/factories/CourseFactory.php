<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'lecturer' => $this->faker->name,
            'thumbnail' => $this->faker->imageUrl(640, 480, 'education', true),
            'num_of_chapters' => $this->faker->numberBetween(5, 20),
            'num_of_lessons' => $this->faker->numberBetween(10, 50),
            'time_to_complete' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->paragraph,
            'starts' => $this->faker->randomFloat(2, 1, 5),
            'fake_cost' => $this->faker->numberBetween(1000, 10000),
            'cost' => $this->faker->numberBetween(500, 5000),
            'duration' => $this->faker->numberBetween(1, 365),
        ];
    }
}
