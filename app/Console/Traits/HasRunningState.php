<?php
namespace App\Console\Traits;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method getName
 */
trait HasRunningState
{
    protected function start()
    {
        $key = $this->getRunningKeyName();
        \Cache::increment($key);
    }

    protected function finish()
    {
        $key = $this->getRunningKeyName();
        \Cache::decrement($key);
        $this->checkRunningValue($key);
    }

    public function isRunning()
    {
        return (bool)($this->running() > 0);
    }

    public function running()
    {
        $key = $this->getRunningKeyName();
        return \Cache::get($key, 0);
    }

    private function getRunningKeyName()
    {
        $key = str_slug(implode(' ', [
            'artisan',
            $this->getName(),
            'running',
        ]));
        $this->checkRunningValue($key);
        return $key;
    }

    private function checkRunningValue($key)
    {
        if(!\Cache::has($key) || \Cache::get($key) < 0) {
            \Cache::put($key, 0, 30);
        }
    }

    private function getLineKeyName()
    {
        $key = str_slug(implode(' ', [
            'artisan',
            $this->getName(),
            'line',
        ]));
        if(!\Cache::has($key)) {
            \Cache::forever($key, '');
        }
        return $key;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->start();
        $return = parent::execute($input, $output);
        $this->finish();
        return $return;
    }

    public function line($string, $style = null, $verbosity = null)
    {
        parent::line($string, $style, $verbosity);
        $this->write($string);
    }

    public function write($string)
    {
        $key = $this->getLineKeyName();
        \Cache::forever($key, (string)$string);
    }

    public function read()
    {
        $key = $this->getLineKeyName();
        return \Cache::get($key, '');
    }
}