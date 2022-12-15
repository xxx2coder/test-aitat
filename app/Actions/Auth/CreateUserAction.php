<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateUserAction
{
    /**
     * @param array $attrs
     * @return User|false
     */
    public function handle(array $attrs)
    {
        try {
            return User::create([
                'name' => $attrs['name'],
                'email' => $attrs['email'],
                'password' => Hash::make($attrs['password'])
            ]);
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return false;
        }
    }
}
