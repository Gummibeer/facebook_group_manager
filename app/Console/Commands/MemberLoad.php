<?php

namespace App\Console\Commands;

use App\Libs\Facebook;
use App\Models\Member;
use Illuminate\Console\Command;

class MemberLoad extends Command
{
    protected $signature = 'member:load';
    protected $description = 'Loads all members from facebook.';

    protected $facebook;

    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;
        parent::__construct();
    }

    public function handle()
    {
        $fb = $this->facebook->getClient();
        $groupId = config('services.facebook.group_id');

        $this->info('load members for group #'.$groupId);
        $response = $fb->get($groupId.'/members?fields=id,first_name,name,picture{is_silhouette},administrator&limit=1000');
        $edge = $response->getGraphEdge();
        $members = collect([]);
        do {
            $this->comment('save graph edge data');
            $members = $members->merge($edge->asArray());
            $bar = $this->output->createProgressBar($edge->count());
            foreach($edge->asArray() as $member) {
                $exists = Member::byId($member['id'])->exists();
                if($exists) {
                    $member = Member::byId($member['id'])->first();
                    $member->update([
                        'first_name' => $member['first_name'],
                        'full_name' => $member['name'],
                        'is_silhouette' => $member['picture']['is_silhouette'],
                        'is_administrator' => $member['administrator'],
                    ]);
                } else {
                    Member::create([
                        'id' => $member['id'],
                        'first_name' => $member['first_name'],
                        'full_name' => $member['name'],
                        'is_silhouette' => $member['picture']['is_silhouette'],
                        'is_administrator' => $member['administrator'],
                        'gender' => 0,
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
