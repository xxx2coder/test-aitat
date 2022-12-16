<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasName
{
    public function scopeByName(Builder $builder, string $name)
    {
        return $builder->where('name', $name);
    }

    static public function firstByName(string $name)
    {
        return self::query()->byName($name)->first();
    }
}
