<?php

namespace Database\Seeders;

use App\Models\Candidature;
use App\Models\Offre;
use App\Models\Profil;
use Illuminate\Database\Seeder;

class CandidatureSeeder extends Seeder
{
    public function run(): void
    {
        $profils = Profil::all();
        $offres  = Offre::where('actif', true)->get();

        if ($offres->count() < 2) {
            return;
        }

        foreach ($profils as $profil) {
            $offresSelectionnees = $offres->random(2);

            foreach ($offresSelectionnees as $offre) {
                Candidature::firstOrCreate(
                    ['offre_id' => $offre->id, 'profil_id' => $profil->id],
                    ['message' => 'Je suis très intéressé par ce poste.', 'statut' => 'en_attente']
                );
            }
        }
    }
}
