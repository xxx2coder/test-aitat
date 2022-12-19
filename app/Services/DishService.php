<?php

namespace App\Services;

use App\Enums\Dish\QuantityType;
use Auth;
use App\Enums\Types;
use App\Models\Dish;
use App\Models\Type;

class DishService
{
    public function create(array $attrs, int $user_id = null)
    {
        if (!$user_id) {
            $attrs['user_id'] = Auth::id();
        }

        $quantityTypes = QuantityType::asArray();

        if (!in_array($attrs['quantity_type'], $quantityTypes)) {
            return null;
        }

        $quantityType = Type::firstOrCreate([
            'name' => $attrs['quantity_type'],
            'type' => Types::Dish_Quantity_Type
        ]);

        $attrs['quantity_type_id'] = $quantityType->id;

        return Dish::create($attrs);
    }

    public function update(Dish $dish, array $attrs)
    {
        $quantityTypes = QuantityType::asArray();

        if (!in_array($attrs['quantity_type'], $quantityTypes)) {
            return null;
        }

        $quantityType = Type::firstOrCreate([
            'name' => $attrs['quantity_type'],
            'type' => Types::Dish_Quantity_Type
        ]);

        $attrs['quantity_type_id'] = $quantityType->id;

        return $dish->update($attrs);
    }

    public function delete(Dish $dish)
    {
        return $dish->delete();
    }
}
