<?php

namespace App\Listeners;

use App\Events\CandidaturePostulee;
use Illuminate\Support\Facades\Log;

class LogCandidature
{
    public function handle(CandidaturePostulee $event): void
    {
        Log::channel('candidatures')->info('Nouvelle candidature', [
            'user_id'  => $event->candidature->user_id,
            'offre_id' => $event->candidature->offre_id,
            'statut'   => $event->candidature->statut,
            'at'       => now(),
        ]);
    }
}