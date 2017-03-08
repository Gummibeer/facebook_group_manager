<?php
namespace App\Libs;


class Gender
{
    const UNKNOWN = 0;
    const FEMALE = 1;
    const MALE = 2;

    protected $labels = [
        self::UNKNOWN => 'unknown',
        self::FEMALE => 'female',
        self::MALE => 'male',
    ];

    protected $icons = [
        self::UNKNOWN => 'fa-genderless',
        self::FEMALE => 'fa-venus',
        self::MALE => 'fa-mars',
    ];

    protected $python;

    public function __construct(Python $python)
    {
        $this->python = $python;
    }

    public function getByName($name)
    {
        $gender = $this->python->call('gender_by_name', $name);
        switch ($gender) {
            default:
            case 'andy':
            case 'unknown':
                return self::UNKNOWN;
            case 'male':
            case 'mostly_male':
                return self::MALE;
            case 'female':
            case 'mostly_female':
                return self::FEMALE;
        }
    }

    public function getLabels()
    {
        return $this->labels;
    }

    public function getLabel($gender)
    {
        return $this->labels[$gender];
    }

    public function getIcons()
    {
        return $this->icons;
    }

    public function getIcon($gender)
    {
        return $this->icons[$gender];
    }
}