<?php

namespace App\Models;

use App\Libs\Facebook;
use App\Libs\Gender;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'first_name',
        'full_name',
        'is_silhouette',
        'is_administrator',
        'gender',
        'gender_by_name',
        'gender_by_picture',
        'is_active',
        'is_approved',
        'age',
        'age_by_picture',
        'hometown_address',
        'hometown_place_id',
        'hometown_lat',
        'hometown_lng',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'facebook_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'from_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'from_id', 'id');
    }

    public function getAvatarAttribute()
    {
        return (new Facebook())->getAvatar($this->id);
    }

    public function getPictureAttribute()
    {
        return 'https://graph.facebook.com/'.$this->id.'/picture?type=large';
    }

    public function getGenderAttribute($value)
    {
        if($value == Gender::UNKNOWN) {
            if($this->gender_by_picture != Gender::UNKNOWN) {
                return $this->gender_by_picture;
            }
            if($this->gender_by_name != Gender::UNKNOWN) {
                return $this->gender_by_name;
            }
        }
        return $value;
    }

    public function getAgeAttribute($value)
    {
        if($value == 0) {
            if($this->age_by_picture != 0) {
                return $this->age_by_picture;
            }
        }
        return $value;
    }

    public function getPostCountAttribute()
    {
        return $this->posts->count();
    }

    public function getCommentCountAttribute()
    {
        return $this->comments->count();
    }

    public function getCoordinatesAttribute()
    {
        return [
            'lat' => $this->hometown_lat,
            'lng' => $this->hometown_lng
        ];
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

    public function scopeByActive(Builder $query, $is = 1) {
        return $query->where('is_active', (int)$is);
    }

    public function scopeByApproved(Builder $query, $is = 1) {
        return $query->where('is_approved', (int)$is);
    }

    public function scopeByAdmin(Builder $query, $is = 1)
    {
        return $query->where('is_administrator', (int)$is);
    }

    public function scopeByGenderName(Builder $query, $gender)
    {
        return $query->where('gender_by_name', $gender);
    }

    public function scopeByIsSilhouette(Builder $query, $is = 1)
    {
        return $query->where('is_silhouette', (int)$is);
    }

    public function scopeWithoutContribution(Builder $query)
    {
        $query->withoutPosts()->withoutComments();
    }

    public function scopeWithoutPosts(Builder $query)
    {
        $query->doesntHave('posts');
    }

    public function scopeWithoutComments(Builder $query)
    {
        $query->doesntHave('comments');
    }

    public function scopeWithHometown(Builder $query)
    {
        $query
            ->where('hometown_lat', '<>', 0)
            ->where('hometown_lng', '<>', 0);
    }

    public function scopeWithAge(Builder $query)
    {
        $query->where('age', '<>', 0);
    }
}
