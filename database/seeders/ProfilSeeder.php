<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Competence;
use App\Models\Profil;

class ProfilSeeder extends Seeder
{
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

            $randomCompetences = $competences->count() >= 3
                ? $competences->random(3)
                : $competences;

            foreach ($randomCompetences as $comp) {
                $profil->competences()->attach($comp->id, [
                    'niveau' => 'intermediaire'
                ]);
            }
        }
    }
}
