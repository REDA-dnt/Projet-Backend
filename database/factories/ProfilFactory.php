<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfilFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titre'        => $this->faker->jobTitle(),
            'bio'          => $this->faker->paragraph(),
            'localisation' => $this->faker->city(),
            'disponible'   => $this->faker->boolean(70),
        ];
    }
}
