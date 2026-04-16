<?php

namespace Database\Factories;

use App\Models\Offre;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Offre>
 */
class OffreFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state([
                'role' => 'recruteur'
            ]),
            'titre' => fake()->jobTitle(),
            'description' => fake()->paragraphs(3, true),
            'localisation' => fake()->city(),
            'type' => fake()->randomElement(['CDI', 'CDD', 'stage']),
            'actif' => true,
        ];
    }
}
