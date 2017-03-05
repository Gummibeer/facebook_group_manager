<?php

namespace App\Console\Commands\Python;

use App\Console\Commands\PythonCommand;

class Gender extends PythonCommand
{
    protected $signature = 'python:gender {name}';
    protected $description = 'Command description';

    public function handle()
    {
        $name = $this->argument('name');
        $gender = $this->runPythonScript('gender_by_name', $name);
        switch ($gender) {
            default:
            case 'unknown':
                $this->line(0);
                break;
            case 'andy':
                $this->line(1);
                break;
            case 'male':
            case 'mostly_male':
                $this->line(2);
                break;
            case 'female':
            case 'mostly_female':
                $this->line(3);
                break;
        }
    }
}
