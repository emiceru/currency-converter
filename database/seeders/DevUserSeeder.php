<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DevUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        $token = $user->createToken('dev-token')->plainTextToken;

        echo "\n============================\n";
        echo "Usuario creado: test@example.com\n";
        echo "Password: password\n";
        echo "Token de acceso:\n$token\n";
        echo "============================\n";
    }
}
