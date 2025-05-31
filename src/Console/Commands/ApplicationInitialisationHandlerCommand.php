<?php

namespace SebenzaTaxi\LaravelAppInit\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\OutputStyle;
use SebenzaTaxi\LaravelAppInit\Libraries\AppInitCommand;
use SebenzaTaxi\LaravelAppInit\Models\InitCommand;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

final class ApplicationInitialisationHandlerCommand extends Command
{
    protected $signature = 'app:init';

    protected $description = 'Initialises the application for first-time use, or for commands not yet run';

    public function handle(): void
    {
        # Fetch all classes in the /inits directory of the application (not this library)
        if ($inits = glob(base_path('inits/*.php'))) {
            $this->info('Running unexecuted initialisation commands');

            # Filter out inits that are present in the "init_commands" table
            $inits = array_filter($inits, function ($init) {
                $initName = pathinfo($init, PATHINFO_FILENAME);
                return !InitCommand::whereCommandName($initName)->exists();
            });

            if (!$inits) {
                $this->line('Nothing to initialise');
                return;
            }

            # Execute them in name-ascending order
            sort($inits);

            foreach ($inits as $init) {
                $initName = pathinfo($init, PATHINFO_FILENAME);
                $this->line(' - ' . $initName);

                # Include the init file and get the class instance
                require $init;
                $instance = new $initName();

                # Ensure that it's an instance of AppInitCommand
                if (!$instance instanceof AppInitCommand) {
                    $this->error("     Class in $init must extend \SebenzaTaxi\LaravelAppInit\Libraries\AppInitCommand");
                    continue;
                }

                # Create an Input/Output style
                $input = new ArgvInput();   // Get the input from the console context
                $output = new ConsoleOutput(); // Standard output
                $outputStyle = new OutputStyle($input, $output); // Wrap it in OutputStyle

                # Set the output to the instance
                $instance->setOutput($outputStyle);

                # Call the 'up' method to execute the initialization logic
                $instance->up();

                # Record that the command was executed
                InitCommand::create(['command_name' => $initName]);
            }
        } else {
            $this->warn('No initialisation commands found');
        }
    }
}