<?php

namespace App\Models;

use Auth;
use App\Traits\HasName;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dish extends Model
{
    use HasFactory, HasName;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'price',
        'quantity',
        'quantity_type_id'
    ];

    protected $with = [
        'category',
        'quantityType'
    ];

    public function scopeForAuth(Builder $builder)
    {
        return $builder->where('user_id', Auth::id());
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function quantityType(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'quantity_type_id', 'id');
    }
}
