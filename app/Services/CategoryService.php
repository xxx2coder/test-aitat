<?php

namespace App\Services;

use Auth;
use App\Models\Category;

class CategoryService
{
    public function create(array $attrs, int $user_id = null)
    {
        if (!$user_id) {
            $attrs['user_id'] = Auth::id();
        }

        return Category::create($attrs);
    }

    public function update(Category $category, array $attrs)
    {
        return $category->update($attrs);
    }

    public function delete(Category $category)
    {
        return $category->delete();
    }
}
