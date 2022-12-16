<?php

namespace App\Models;

use Auth;
use App\Traits\HasName;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasName;

    protected $fillable = [
        'user_id',
        'name'
    ];

    public function scopeForAuth(Builder $builder)
    {
        return $builder->where('user_id', Auth::id());
    }
}
