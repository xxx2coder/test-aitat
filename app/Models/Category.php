<?php

namespace App\Models;

use App\Traits\HasUser;
use App\Traits\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasName, HasUser;

    protected $fillable = [
        'user_id',
        'name'
    ];
}
