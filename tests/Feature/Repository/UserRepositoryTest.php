<?php

namespace Tests\Feature\Repository;

use App\Interfaces\RepositoryInterface;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{

    public static function repository(): RepositoryInterface
    {
        return new UserRepository();
    }

    public function test_get_all_users(): void
    {
        $users = self::repository()->all();

        $this->assertNotEmpty($users);
    }

    public function test_create_user(): void 
    {
        $user = self::repository()->create([
            ...User::factory()->make()->toArray(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);

        $this->assertNotEmpty($user);
        $this->assertIsInt($user->id);
    }

    public function test_update_user(): void 
    {
        $user = User::query()->inRandomOrder()->first(['id']);
        $result = self::repository()->update($user->id, [ 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        $this->assertEquals($result, 1);
    }

    public function test_find_user(): void 
    {
        $user = User::query()->inRandomOrder()->first(['id']);
        $user = self::repository()->find($user->id);

        $this->assertNotEmpty($user->id);
        $this->assertNotEmpty($user->name);
    }

    public function test_delete_user(): void 
    {
        $user = User::query()->orderByDesc('id')->first(['id']);
        $result = self::repository()->delete($user->id);

        $this->assertNotEmpty($result);
    }
}
