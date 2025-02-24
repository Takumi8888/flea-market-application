<?php

namespace Database\Factories\Profile;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'   => $this->faker->unique()->numberBetween(1, 8),
            'user_name' => $this->faker->userName(),
            'image'     => $this->faker->randomElement([
                'image/profile/Profile1.png',
                'image/profile/Profile2.png',
                'image/profile/Profile3.png',
                'image/profile/Profile4.png',
            ]),
            'postcode'  => $this->faker->numerify('###-####'),
            'address'   =>
                $this->faker->prefecture() .
                $this->faker->ward() .
                $this->faker->city() .
                $this->faker->streetAddress(),
            'building'  => $this->faker->secondaryAddress(),
        ];
    }
}
