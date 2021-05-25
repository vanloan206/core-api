<?php

namespace App\Console\Commands;

use Lorisleiva\Actions\Commands\MakeActionCommand as ConsoleMakeActionCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeActionCommand extends ConsoleMakeActionCommand
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
            return $this->laravel->getNamespace() . 'Domain\\' . $this->option('domain') . '\\Actions';
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
            ['domain', null, InputOption::VALUE_REQUIRED, 'Indicates the domain which action is placed']
        ]);
    }

    protected function getStub()
    {
        return $this->laravel->basePath('app/Console/stubs/action.stub');
    }
}
