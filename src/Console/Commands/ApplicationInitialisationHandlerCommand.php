<?php

namespace SebenzaTaxi\LaravelAppInit\Console\Commands;

use Illuminate\Console\Command;

final class ApplicationInitialisationHandlerCommand extends Command
{
    protected $signature = 'app:init';

    protected $description = 'Initialises the application for first-time use, or for commands not yet run';

    public function handle(): void
    {
        # Fetch all classes in the /inits directory of the application (not this library)
        $inits = glob(base_path('inits/*.php'));

        dd($inits);

    }
}