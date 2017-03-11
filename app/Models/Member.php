<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'first_name',
        'full_name',
        'is_silhouette',
        'is_administrator',
        'gender',
        'gender_by_name',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'facebook_id', 'id');
    }

    public function getAvatarAttribute()
    {
        return 'https://graph.facebook.com/'.$this->id.'/picture?type=square';
    }

    public function getPictureAttribute()
    {
        return 'https://graph.facebook.com/'.$this->id.'/picture?type=large';
    }

    public function getGenderAttribute($value)
    {
        if($value == 0) {
            return $this->gender_by_name;
        }
        return $value;
    }

    public function inactivate()
    {
        $this->update([
            'is_active' => 0,
        ]);
    }

    public function scopeById(Builder $query, $id) {
        if(is_array($id)) {
            return $query->whereIn('id', $id);
        }
        return $query->where('id', $id);
    }

    public function scopeByActive(Builder $query, $active = 1) {
        return $query->where('is_active', (int)$active);
    }

    public function scopeByAdmin(Builder $query, $admin = 1)
    {
        return $query->where('is_administrator', (int)$admin);
    }

    public function scopeByGenderName(Builder $query, $gender)
    {
        return $query->where('gender_by_name', $gender);
    }

    public function scopeByIsSilhouette(Builder $query, $is = 1)
    {
        return $query->where('is_silhouette', (int)$is);
    }
}
