<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeModelCommand extends ModelMakeCommand
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
            return $this->laravel->getNamespace() . 'Domain\\' . $this->option('domain') . '\\Models';
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
            ['domain', null, InputOption::VALUE_REQUIRED, 'Indicates the domain which model is placed']
        ]);
    }
}
