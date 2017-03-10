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

    public function inactivate()
    {
        $this->update([
            'active' => false,
        ]);
    }

    public function scopeById(Builder $query, $id) {
        if(is_array($id)) {
            return $query->whereIn('id', $id);
        }
        return $query->where('id', $id);
    }

    public function scopeByActive(Builder $query, $active = true) {
        return $query->where('is_active', (int)$active);
    }

    public function scopeByAdmin(Builder $query, $admin = true)
    {
        return $query->where('is_administrator', (int)$admin);
    }

    public function scopeByGender(Builder $query, $gender)
    {
        return $query->where('gender', $gender);
    }
}
