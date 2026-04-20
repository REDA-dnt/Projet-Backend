<?php

namespace App\Listeners;

use App\Events\CandidatureDeposee;
use Illuminate\Support\Facades\Log;

class LogCandidatureDeposee
{
    public function handle(CandidatureDeposee $event): void
    {
        $candidature = $event->candidature->load('profil.user', 'offre');

        Log::channel('candidatures')->info('Nouvelle candidature déposée', [
            'date'           => now()->toDateTimeString(),
            'candidat'       => $candidature->profil->user->name,
            'offre'          => $candidature->offre->titre,
            'candidature_id' => $candidature->id,
            'statut'         => $candidature->statut,
        ]);
    }
}
