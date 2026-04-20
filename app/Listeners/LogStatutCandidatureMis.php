<?php

namespace App\Listeners;

use App\Events\StatutCandidatureMis;
use Illuminate\Support\Facades\Log;

class LogStatutCandidatureMis
{
    public function handle(StatutCandidatureMis $event): void
    {
        $candidature = $event->candidature;

        Log::info("STATUT CANDIDATURE MODIFIÉ", [
            'candidature_id' => $candidature->id,
            'ancien_statut'  => $candidature->getOriginal('statut'),
            'nouveau_statut' => $candidature->statut,
            'date'           => now(),
        ]);
    }
}
