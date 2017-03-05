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
        return $query->where('active', $active);
    }
}
