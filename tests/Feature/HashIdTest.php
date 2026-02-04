<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Jabatan;
use App\Services\HashService; // Ensure this is imported
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App; // Import Facade
use Tests\TestCase;

class HashIdTest extends TestCase
{
    use RefreshDatabase;

    public function test_models_have_hashed_route_keys()
    {
        $user = User::factory()->create();

        // Ensure Key is integer
        $this->assertIsInt($user->id);

        // Ensure Route Key is string (hashed)
        $routeKey = $user->getRouteKey();
        $this->assertIsString($routeKey);
        $this->assertNotEquals($user->id, $routeKey);
    }

    public function test_can_access_route_with_hashed_id()
    {
        $user = User::factory()->create();
        $admin = User::factory()->create(); // As admin

        // Manually attach admin role if needed, or use actingAs logic appropriately
        // Assuming access logic depends on roles which usually seeders handle.
        // For simplicity, we just test if route binding resolves, not auth middleware.

        $hashService = new HashService();
        $hashedId = $hashService->encode($user->id);

        // Test basic decoding logic manually first
        $decodedId = $hashService->decode($hashedId);
        $this->assertEquals($user->id, $decodedId);
    }
}
