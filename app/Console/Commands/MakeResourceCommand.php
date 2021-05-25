<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ResourceMakeCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeResourceCommand extends ResourceMakeCommand
{
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        if ($this->option('domain')) {
            return $this->laravel->getNamespace() . 'Domain\\' . $this->option('domain') . '\\Resources';
        }

        return $rootNamespace;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            ['domain', null, InputOption::VALUE_REQUIRED, 'Indicates the domain which resource is placed']
        ]);
    }

    protected function getStub()
    {
        return $this->collection()
            ? $this->laravel->basePath('app/Console/stubs/resource-collection.stub')
            : $this->laravel->basePath('app/Console/stubs/resource.stub');
    }
}
