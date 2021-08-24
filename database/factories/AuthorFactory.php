<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Author::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $firstName = rand(0, 1) ? $this->faker->firstNameFemale : $this->faker->firstNameMale;

        return [
            'user_id' => $this->faker->unique->numberBetween(1, 14),
            'first_name' => $firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
