<?php

namespace SebenzaTaxi\LaravelAppInit\Libraries;

use Illuminate\Console\Command;

abstract class AppInitCommand extends Command
{
    abstract public function up();

    public function call($command, array $parameters = [])
    {
        resolve(\Illuminate\Contracts\Console\Kernel::class)->call($command, $parameters);
    }
}