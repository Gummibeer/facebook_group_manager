<?php

namespace App\Console\Commands;

use App\Console\Traits\HasRunningState;
use App\Libs\Facebook;
use App\Models\Member;
use App\Console\Command;

class MemberLoad extends Command
{
    use HasRunningState;
    
    protected $signature = 'load:members';
    protected $description = 'Loads all members from facebook.';

    protected $facebook;

    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;
        parent::__construct();
    }

    public function handle()
    {
        $fb = $this->facebook->getClient(true);
        $groupId = config('services.facebook.group_id');

        $this->info('load members for group #'.$groupId);
        $response = $fb->get($groupId.'/members?fields=id,first_name,name,picture{is_silhouette},administrator,devices,age_range,gender&limit=1000');
        $edge = $response->getGraphEdge();
        $members = collect([]);
        do {
            $this->comment('save graph edge data');
            $members = $members->merge($edge->asArray());
            $bar = $this->output->createProgressBar($edge->count());
            foreach($edge->asArray() as $fbMember) {
                $exists = Member::byId($fbMember['id'])->exists();
                if($exists) {
                    $member = Member::byId($fbMember['id'])->first();
                    $member->update([
                        'first_name' => $fbMember['first_name'],
                        'full_name' => $fbMember['name'],
                        'is_silhouette' => $fbMember['picture']['is_silhouette'],
                        'is_administrator' => $fbMember['administrator'],
                    ]);
                } else {
                    Member::create([
                        'id' => $fbMember['id'],
                        'first_name' => $fbMember['first_name'],
                        'full_name' => $fbMember['name'],
                        'is_silhouette' => $fbMember['picture']['is_silhouette'],
                        'is_administrator' => $fbMember['administrator'],
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
        $oldMembers = Member::where('is_active', 1)->whereNotIn('id', $members->pluck('id')->toArray())->get();
        $this->info('new inactive members '.$oldMembers->count());
        foreach ($oldMembers as $member) {
            $member->inactivate();
        }
    }
}
