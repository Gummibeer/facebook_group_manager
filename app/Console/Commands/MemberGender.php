<?php

namespace App\Console\Commands;

use App\Libs\Gender;
use App\Models\Member;
use Illuminate\Console\Command;

class MemberGender extends Command
{
    protected $signature = 'member:gender';
    protected $description = 'Sets gender by name.';

    protected $gender;

    public function __construct(Gender $gender)
    {
        $this->gender = $gender;
        parent::__construct();
    }

    public function handle()
    {
        $members = Member::byGender(Gender::UNKNOWN)->get();
        $this->info('search gender for '.$members->count().' members');
        $bar = $this->output->createProgressBar($members->count());
        foreach($members as $member) {
            $member->update([
                'gender' => $this->gender->getByName($member->first_name),
            ]);
            $bar->advance();
        }
        $bar->finish();
        $this->line('');
    }
}