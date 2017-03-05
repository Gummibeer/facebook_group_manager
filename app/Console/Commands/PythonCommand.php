<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

abstract class PythonCommand extends Command
{
    protected function runPythonScript($script, $arg)
    {
        $path = base_path('python');
        $file = realpath($path.DIRECTORY_SEPARATOR.$script.'.py');
        $process = new Process('python '.$file.' "'.addslashes($arg).'"');
        $process->mustRun();
        sleep(0.25);
        return trim($process->getOutput());
    }
}
