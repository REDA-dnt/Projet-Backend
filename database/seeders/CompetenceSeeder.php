<?php

namespace Database\Seeders;

use App\Models\Competence;
use Illuminate\Database\Seeder;

class CompetenceSeeder extends Seeder
{
    public function run(): void
    {
        $competences = [
            ['nom' => 'PHP',         'categorie' => 'Backend'],
            ['nom' => 'Laravel',     'categorie' => 'Backend'],
            ['nom' => 'JavaScript',  'categorie' => 'Frontend'],
            ['nom' => 'React',       'categorie' => 'Frontend'],
            ['nom' => 'MySQL',       'categorie' => 'Base de données'],
            ['nom' => 'Docker',      'categorie' => 'DevOps'],
            ['nom' => 'Git',         'categorie' => 'Outils'],
            ['nom' => 'Python',      'categorie' => 'Backend'],
            ['nom' => 'Vue.js',      'categorie' => 'Frontend'],
            ['nom' => 'PostgreSQL',  'categorie' => 'Base de données'],
        ];

        foreach ($competences as $competence) {
            Competence::firstOrCreate(['nom' => $competence['nom']], $competence);
        }
    }
}
