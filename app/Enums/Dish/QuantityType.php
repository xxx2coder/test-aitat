<?php

namespace App\Enums\Dish;

use BenSampo\Enum\Enum;

/**
 * @method static static piece()
 * @method static static kilogram()
 * @method static static liter()
 */
final class QuantityType extends Enum
{
    const Piece = 'piece';
    const Kilogram = 'kilogram';
    const Liter = 'liter';
}
