<?php

namespace Nonsapiens\LaravelAppInit\Libraries;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Kernel;

abstract class AppInitCommand extends Command
{
    /**
     * @var bool If set to TRUE, the command will run every time, even if it has been run before.
     */
    protected bool $runEveryTime = false;

    abstract public function up();

    public function call($command, array $parameters = [])
    {
        resolve(Kernel::class)->call($command, $parameters);
    }

    public function shouldRunEveryTime(): bool
    {
        return $this->runEveryTime;
    }
}