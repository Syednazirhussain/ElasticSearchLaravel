<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::pluck('id')->toArray();

        return [
            'title' => $this->faker->name(),
            'body' => $this->faker->text(191),
            'user_id' => $this->faker->randomElement($users),
        ];
    }
}
