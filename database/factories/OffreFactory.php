<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OffreFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titre'        => $this->faker->jobTitle(),
            'description'  => $this->faker->paragraph(),
            'localisation' => $this->faker->city(),
            'type'         => $this->faker->randomElement(['CDI', 'CDD', 'stage']),
            'actif'        => $this->faker->boolean(80),
        ];
    }
}
