<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;

class CurrencyConversionTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_convert_currency()
    {
        // Simular respuesta de la API externa
        Http::fake([
            'https://open.er-api.com/*' => Http::response([
                'rates' => [
                    'EUR' => 0.91,
                ]
            ], 200),
        ]);

        // Crear usuario y token con Sanctum
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Hacer petición autenticada
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->getJson('/api/convert?from=USD&to=EUR&amount=100');

        // Verificar resultado
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'from',
            'to',
            'amount',
            'rate',
            'converted_amount',
        ]);

        $response->assertJson([
            'from' => 'USD',
            'to' => 'EUR',
            'amount' => 100.0,
            'rate' => 0.91,
            'converted_amount' => 91.0,
        ]);
    }

    public function test_guest_user_cannot_access_convert_endpoint()
    {
        $response = $this->getJson('/api/convert?from=USD&to=EUR&amount=100');

        $response->assertStatus(401);
    }
}
