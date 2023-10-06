<?php

namespace Tests\Feature\Service;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_filter_by_users(): void
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/api/users');

        $this->assertAuthenticated();
        $response->assertOk();
    }
}
