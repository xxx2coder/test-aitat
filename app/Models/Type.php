<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasName;

class Type extends Model
{
    use HasFactory, HasName;

    protected $fillable = [
        'name',
        'type'
    ];

    public function scopeByType(Builder $builder, string $type)
    {
        return $builder->where('type', $type);
    }
}
