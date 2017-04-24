<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    public $keyType = 'string';

    protected $fillable = [
        'id',
        'message',
        'created_at',
        'from_id',
        'from_name',
        'picture',
        'sentiment',
    ];

    public function from()
    {
        return $this->belongsTo(Member::class, 'from_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function scopeById(Builder $query, $id) {
        if(is_array($id)) {
            return $query->whereIn('id', $id);
        }
        return $query->where('id', $id);
    }

    public function scopeWithPicture(Builder $query) {
        return $query->whereNotNull('picture');
    }

    public function scopeByCreatedAt(Builder $query, $modify) {
        $date = Carbon::now('UTC')->modify($modify);
        return $query->where('created_at', '>=', $date);
    }

    public function scopeWithoutSentiment(Builder $query) {
        return $query->whereNull('sentiment');
    }
}
