<?php

namespace Nonsapiens\LaravelAppInit\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateInitCommand extends Command
{
    protected $signature = 'init:create {name : The name of the init file}';

    protected $description = 'Create a new application init file';

    public function handle(): void
    {
        $name = Str::snake($this->argument('name'));
        $timestamp = Carbon::now()->format('Y_m_d_His');
        $filename = sprintf('%s_%s.php', $timestamp, $name);

        $directory = base_path('inits');
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = $directory . DIRECTORY_SEPARATOR . $filename;

        $stub = <<<PHP
<?php

use Nonsapiens\\LaravelAppInit\\Libraries\\AppInitCommand;

return new class extends AppInitCommand
{
    public function up()
    {
        //
    }
};
PHP;

        file_put_contents($path, $stub);

        $this->info("Init created: {$filename}");
    }
}
