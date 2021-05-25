<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeDomainCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use this command to generate domain structure';

    /**
     * Execute the console command.
     */
    public function handle(Filesystem $fileSystem)
    {
        $name = Str::ucfirst($this->argument('name'));

        // NOTE: copy from laravel/framework/src/Illuminate/Console/GeneratorCommand.php@getPath
        $basePath = $this->laravel['path'] . '//Domain//' . str_replace('\\', '/', $name);

        // Initializing the domain
        $this->info('Initializing the domain');
        $folders = ['Actions', 'Jobs', 'Events', 'Resources', 'Services', 'Filters'];
        foreach ($folders as $folder) {
            $path = $basePath . '/' . $folder;
            $fileSystem->makeDirectory($path, 0777, true, true);
            $fileSystem->put($path . '/.gitkeep', '');
        }

        // $this->call('make:model', [ 'name' => $name, '--domain' => $name ]);
        $this->call('make:resource', [ 'name' => $name . 'Resource', '--domain' => $name ]);
        $this->call('make:resource', [ 'name' => $name . 'Collection', '--domain' => $name, '--collection' => true ]);

        // Make actions for CRUD
        $this->call('make:action', [ 'name' => 'List' . $name . 'Action', '--domain' => $name ]);
        $this->call('make:action', [ 'name' => 'Show' . $name . 'Action', '--domain' => $name ]);
        $this->call('make:action', [ 'name' => 'Store' . $name . 'Action', '--domain' => $name ]);
        $this->call('make:action', [ 'name' => 'Update' . $name . 'Action', '--domain' => $name ]);
        $this->call('make:action', [ 'name' => 'Destroy' . $name . 'Action', '--domain' => $name ]);
    }
}
