<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\CandidatureDeposee::class => [
            \App\Listeners\LogCandidatureDeposee::class,
        ],

        \App\Events\StatutCandidatureMis::class => [
            \App\Listeners\LogStatutCandidatureMis::class,
        ],
    ];
}
