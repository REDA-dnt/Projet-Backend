<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProfilSeeder extends Seeder
{
    public function run(): void
    {
        $candidats = \App\Models\User::where('role', 'candidat')->get();

        foreach ($candidats as $candidat) {
            \App\Models\Profil::factory()->create([
                'user_id' => $candidat->id,
            ]);
        }
    }
}
