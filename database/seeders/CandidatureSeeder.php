<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $profils = Profil::all();
    $offres = Offre::where('actif', true)->get();

    foreach ($profils as $profil) {
        $offresSelectionnees = $offres->random(2);
        
        foreach ($offresSelectionnees as $offre) {
            Candidature::create([
                'offre_id' => $offre->id,
                'profil_id' => $profil->id,
                'message' => 'Je suis très intéressé par ce poste.',
                'statut' => 'en_attente'
            ]);
        }
    }
}
}
