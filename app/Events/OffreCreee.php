<?php

namespace App\Events;

use App\Models\Offre;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OffreCreee
{
    use Dispatchable, SerializesModels;

    public function __construct(public Offre $offre) {}
}