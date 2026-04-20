<?php

namespace Database\Factories;

use App\Models\Offre;
use App\Models\Profil;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatureFactory extends Factory
{
    public function definition(): array
    {
        return [
            'offre_id'  => Offre::factory(),
            'profil_id' => Profil::factory(),
            'message'   => fake()->paragraph(),
            'statut'    => fake()->randomElement(['en_attente', 'acceptee', 'refusee']),
        ];
    }
}
