<?php
namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Command as IlluminateCommand;

class Command extends IlluminateCommand
{
    public function comment($string, $verbosity = null)
    {
        parent::comment($string, $verbosity);
        \Log::debug($string, $this->getLogContext());
    }

    public function info($string, $verbosity = null)
    {
        parent::info($string, $verbosity);
        \Log::info($string, $this->getLogContext());
    }

    public function warn($string, $verbosity = null)
    {
        parent::warn($string, $verbosity);
        \Log::warning($string, $this->getLogContext());
    }

    public function error($string, $verbosity = null)
    {
        parent::error($string, $verbosity);
        \Log::error($string, $this->getLogContext());
    }

    protected function getLogContext()
    {
        $now = Carbon::now('UTC');
        return [
            'cli' => true,
            'timestamp' => $now->getTimestamp(),
            'datetime' => $now->format('Y-m-d H:i:s T'),
            'class' => get_class($this),
            'command' => $this->getName(),
        ];
    }
}