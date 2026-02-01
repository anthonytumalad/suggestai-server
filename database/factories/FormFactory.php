<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FormFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'title'       => $title,
            'slug'        => Str::slug($title),
            'description' => $this->faker->paragraph(),
            'is_active'   => $this->faker->boolean(80),
            'img_path'    => null,
            'user_id'     => User::inRandomOrder()->first()->id,
        ];
    }
}
