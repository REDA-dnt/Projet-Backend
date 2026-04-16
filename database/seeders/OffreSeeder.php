<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OffreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $recruteurs = User::where('role', 'recruteur')->get();

    foreach ($recruteurs as $user) {
        Offre::factory()->count(rand(2, 3))->create([
            'user_id' => $user->id
        ]);
    }
}
}
