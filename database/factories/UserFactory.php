<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'kata_sandi' => static::$password ??= Hash::make('password'),
            'peran' => 'penghuni',
            'nomor_telepon' => fake()->numerify('08##########'),
            'remember_token' => Str::random(10),
        ];
    }
}
