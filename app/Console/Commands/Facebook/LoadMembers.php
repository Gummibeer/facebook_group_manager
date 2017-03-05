<?php

namespace App\Console\Commands\Facebook;

use App\Console\Commands\FacebookCommand;
use App\Models\Member;

class LoadMembers extends FacebookCommand
{
    protected $signature = 'facebook:member:load';
    protected $description = 'Command description';

    public function handle()
    {
        $groupId = 1561917967449058;

        $this->info('load members for group #'.$groupId);
        $fb = $this->getFacebook();
        $response = $fb->get($groupId.'/members?fields=id,first_name,name,picture{is_silhouette},administrator&limit=1000');
        $edge = $response->getGraphEdge();
        $members = collect([]);
        do {
            $this->comment('save graph edge data');
            $members = $members->merge($edge->asArray());
            $bar = $this->output->createProgressBar($edge->count());
            foreach($edge->asArray() as $member) {
                $exists = Member::byId($member['id'])->exists();
                if(!$exists) {
                    \Artisan::call('python:gender', [
                        'name' => $member['first_name'],
                    ]);
                    $gender = trim(\Artisan::output()) * 1;
                    Member::create([
                        'id' => $member['id'],
                        'first_name' => $member['first_name'],
                        'full_name' => $member['name'],
                        'is_silhouette' => $member['picture']['is_silhouette'],
                        'is_administrator' => $member['administrator'],
                        'gender' => $gender,
                    ]);
                }
                $bar->advance();
            }
            $bar->finish();
            $this->line('');
            $edge = $fb->next($edge);
        } while(!is_null($edge));
        $this->info('scraped '.$members->count().' members data');
        $oldMembers = Member::byActive()->byId($members->pluck('id')->toArray())->get();
        $this->info('new inactive members '.$oldMembers->count());
        foreach ($oldMembers as $member) {
            $member->inactivate();
        }
    }
}
