<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 
        'email',
        'facebook_id',
        'facebook_token',
        'is_admin',
    ];

    protected $hidden = [
        'facebook_token',
        'remember_token',
    ];

    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'facebook_id');
    }

    public function hasMember()
    {
        return $this->member()->exists();
    }

    public function getAvatarAttribute()
    {
        if($this->hasMember()) {
            return $this->member->avatar;
        }
        return 'https://graph.facebook.com/'.$this->facebook_id.'/picture?type=square';
    }

    public function scopeByAdmin(Builder $query, $admin = true)
    {
        return $query->where('is_admin', (int)$admin);
    }

    public function scopeByEmail(Builder $query, $email)
    {
        return $query->where('email', $email);
    }

    public function scopeByFacebookId(Builder $query, $id)
    {
        return $query->where('facebook_id', $id);
    }
}
