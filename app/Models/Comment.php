<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'message',
        'created_at',
        'from_id',
        'from_name',
        'post_id',
        'parent_id',
    ];

    public function from()
    {
        return $this->belongsTo(Member::class, 'from_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

    public function scopeById(Builder $query, $id) {
        if(is_array($id)) {
            return $query->whereIn('id', $id);
        }
        return $query->where('id', $id);
    }

    public function scopeWithoutParent(Builder $query)
    {
        $query->whereNull('parent_id');
    }

    public function scopeWithParent(Builder $query)
    {
        $query->whereNotNull('parent_id');
    }

    public function scopeByParent(Builder $query, $parentId)
    {
        $query->where('parent_id', $parentId);
    }
}
