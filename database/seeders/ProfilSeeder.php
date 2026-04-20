<?php

namespace Database\Seeders;

use App\Models\Competence;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfilSeeder extends Seeder
{
    public function run(): void
    {
        $candidats   = User::where('role', 'candidat')->get();
        $competences = Competence::all();

        foreach ($candidats as $user) {
            $profil = Profil::create([
                'user_id'      => $user->id,
                'titre'        => 'Développeur Fullstack',
                'bio'          => 'Passionné par Laravel et React.',
                'localisation' => 'Casablanca',
                'disponible'   => true,
            ]);

            $selection = $competences->count() >= 3
                ? $competences->random(3)
                : $competences;

            foreach ($selection as $competence) {
                $profil->competences()->attach($competence->id, [
                    'niveau' => 'intermediaire',
                ]);
            }
        }
    }
}
