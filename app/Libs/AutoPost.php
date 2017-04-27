<?php
namespace App\Libs;


use Carbon\Carbon;
use Cron\CronExpression;
use Illuminate\Console\Scheduling\ManagesFrequencies;

class AutoPost
{
    use ManagesFrequencies;

    protected $expression = '* * * * * *';
    protected $timezone = 'UTC';
    protected $isDue = null;

    protected $message;
    protected $source;
    protected $url;
    protected $link;

    protected $fb;

    public function __construct()
    {
        $this->fb = (new Facebook())->getClient(false,  ['user_managed_groups', 'publish_actions']);
    }

    public function publish()
    {
        if($this->isDue()) {
            try {
                $response = $this->fb->post($this->getEndpoint(), $this->getData());
                return $response->getGraphNode()['post_id'];
            } catch(\Exception $ex) {
                return false;
            }
        }
        return false;
    }

    public function message($value)
    {
        $this->message = $value;
        return $this;
    }

    public function file($value)
    {
        $this->source($this->fb->fileToUpload($value));
        return $this;
    }

    public function source($value)
    {
        $this->source = $value;
        return $this;
    }

    public function url($value)
    {
        $this->url = $value;
        return $this;
    }

    public function link($value)
    {
        $this->link = $value;
        return $this;
    }

    protected function getEndpoint()
    {
        $endpoint = '/'.config('services.facebook.group_id').'/';
        if($this->isPhoto()) {
            return $endpoint.'photos';
        }
        return $endpoint.'feed';
    }

    protected function getData()
    {
        if($this->isPhoto()) {
            return array_filter([
                'message' => $this->getParsedMessage(),
                'url' => $this->url,
                'source' => $this->source,
            ]);
        }
        return array_filter([
            'message' => $this->getParsedMessage(),
            'link' => $this->link,
        ]);
    }

    public function isPhoto()
    {
        return (!empty($this->source) || !empty($this->url));
    }

    public function isDue()
    {
        if(is_null($this->isDue)) {
            $date = Carbon::now($this->timezone);

            $this->isDue = CronExpression::factory($this->expression)->isDue($date->toDateTimeString());
        }
        return $this->isDue;
    }
    
    public function getParsedMessage()
    {
        $now = Carbon::now($this->timezone);
        $replacers = [
            '{weekday}' => trans('date.weekdays.'.$now->dayOfWeek),
        ];
        
        $message = $this->message;
        $message = str_replace(array_keys($replacers), array_values($replacers), $message);
        $message = preg_replace_callback('/{emoji:([\d]+)}/', function($match) {
            return html_entity_decode('&#'.$match[1].';');
        }, $message);

        return $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getExpression()
    {
        return $this->expression;
    }

    public function getTimezone()
    {
        return $this->timezone;
    }

    public function getNextDate()
    {
        $now = Carbon::now($this->timezone);
        return CronExpression::factory($this->expression)->getNextRunDate($now);
    }
}