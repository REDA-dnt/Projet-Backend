<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OffreSeeder extends Seeder
{
    public function run(): void
    {
        $recruteurs = \App\Models\User::where('role', 'recruteur')->get();

        foreach ($recruteurs as $recruteur) {
            \App\Models\Offre::factory(rand(2, 3))->create([
                'user_id' => $recruteur->id,
            ]);
        }
    }
}
