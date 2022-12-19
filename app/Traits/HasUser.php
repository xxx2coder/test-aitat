<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasUser
{
    public function isAuthor(int $user_id)
    {
        return $this->user_id === $user_id;
    }

    public function scopeByUser(Builder $builder, int $user_id)
    {
        return $builder->where('user_id', $user_id);
    }
}
