<?php

namespace App\Listeners;

use App\Events\OffreCreee;
use Illuminate\Support\Facades\Log;

class LogOffre
{
    public function handle(OffreCreee $event): void
    {
        Log::channel('offres')->info('Nouvelle offre créée', [
            'user_id' => $event->offre->user_id,
            'titre'   => $event->offre->titre,
            'at'      => now(),
        ]);
    }
}