<?php

namespace App\Listeners;

use App\Events\CandidatureDeposee;
use Illuminate\Support\Facades\Log;

class LogCandidatureDeposee
{
    public function handle(CandidatureDeposee $event): void
    {
        $candidature = $event->candidature;

        Log::info('Nouvelle candidature déposée', [
            'candidature_id' => $candidature->id,
            'profil_id'      => $candidature->profil_id,
            'offre_id'       => $candidature->offre_id,
            'statut'         => $candidature->statut,
            'date'           => now(),
        ]);
    }
}