<?php

namespace Database\Factories;

use App\Models\TaiKhoan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/** @extends Factory<TaiKhoan> */
class TaiKhoanFactory extends Factory
{
    protected $model = TaiKhoan::class;
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'ho_ten' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'mat_khau' => static::$password ??= Hash::make('password'),
            'so_dien_thoai' => fake()->numerify('09########'),
            'vai_tro' => 'khach_hang',
            'trang_thai' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => ['vai_tro' => 'admin']);
    }
}
