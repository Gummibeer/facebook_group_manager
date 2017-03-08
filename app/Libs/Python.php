<?php
namespace App\Libs;

use Symfony\Component\Process\Process;

class Python
{
    protected function getLibPath()
    {
        return app_path('Libs/python');
    }

    protected function getScriptPath($script)
    {
        return realpath($this->getLibPath().DIRECTORY_SEPARATOR.$script.'.py');
    }

    protected function getPythonBin()
    {
        return 'python';
    }

    protected function constructCommand($script, $arg)
    {
        $bin = $this->getPythonBin();
        $script = $this->getScriptPath($script);
        $args = '"'.addslashes($arg).'"';
        return implode(' ', [$bin, $script, $args]);
    }

    protected function getProcess($script, $arg)
    {
        return new Process($this->constructCommand($script, $arg));
    }

    public function call($script, $arg)
    {
        $process = $this->getProcess($script, $arg);
        $process->mustRun();
        sleep(0.25);
        return trim($process->getOutput());
    }
}