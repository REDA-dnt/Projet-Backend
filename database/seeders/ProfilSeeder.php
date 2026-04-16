<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    $candidats = User::where('role', 'candidat')->get();
    $competences = Competence::all();

    foreach ($candidats as $user) {
        $profil = Profil::create([
            'user_id' => $user->id,
            'titre' => 'Développeur Fullstack',
            'bio' => 'Passionné par Laravel et React.',
            'localisation' => 'Casablanca',
            'disponible' => true,
        ]);

        $randomCompetences = $competences->random(3);
        foreach ($randomCompetences as $comp) {
            $profil->competences()->attach($comp->id, ['niveau' => 'intermédiaire']);
        }
    }
}
}
