<?php

namespace Nonsapiens\LaravelAppInit\Libraries;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Kernel;

abstract class AppInitCommand extends Command
{
    abstract public function up();

    public function call($command, array $parameters = [])
    {
        resolve(Kernel::class)->call($command, $parameters);
    }
}