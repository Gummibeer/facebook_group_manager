<?php

namespace App\Console\Commands;

use App\Libs\Gender;
use App\Models\Member;
use Aws\Rekognition\Exception\RekognitionException;
use Aws\Rekognition\RekognitionClient;
use Illuminate\Console\Command;

class MemberGenderPicture extends Command
{
    protected $signature = 'member:gender:picture';
    protected $description = 'Sets gender by picture.';

    protected $gender;

    public function __construct(Gender $gender)
    {
        $this->gender = $gender;
        parent::__construct();
    }

    public function handle()
    {
        $client = new RekognitionClient([
            'region'  => 'eu-west-1',
            'version' => 'latest',
        ]);
        $members = Member::byActive()->get()->where('gender_by_picture', Gender::UNKNOWN);

        $this->info('search gender for '.$members->count().' members');
        $bar = $this->output->createProgressBar($members->count());
        foreach($members as $member) {
            try {
                $result = $client->detectFaces([
                    'Attributes' => ['ALL'],
                    'Image' => [
                        'Bytes' => file_get_contents($member->picture),
                    ],
                ])->toArray();
            } catch (RekognitionException $ex) {
                continue;
            }

            $details = array_first(array_get($result, 'FaceDetails', []));
            if(is_null($details)) {
                continue;
            }
            $awsAgeRange = array_get($details, 'AgeRange', []);
            $awsGender = array_get($details, 'Gender', []);

            $age = array_sum($awsAgeRange) / count($awsAgeRange);
            switch (strtolower(array_get($awsGender, 'Value'))) {
                case 'female':
                    $gender = Gender::FEMALE;
                    break;
                case 'male':
                    $gender = Gender::MALE;
                    break;
                default:
                    $gender = Gender::UNKNOWN;
                    break;
            }

            $member->update([
                'gender_by_picture' => $gender,
                'age_by_picture' => $age,
            ]);
            $bar->advance();
        }
        $bar->finish();
        $this->line('');
    }
}
