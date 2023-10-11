<?php

namespace Tests\Feature\Repository;

use App\Interfaces\RepositoryInterface;
use App\Models\Customer;
use App\Models\User;
use App\Repository\CustomerRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerRepositoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public static function repository(): RepositoryInterface
    {
        return new CustomerRepository;
    }

    public function test_get_all_customers(): void
    {
        $customers = self::repository()->all();
        if (count($customers) == 0) {
            $this->assertEmpty($customers);
            return;
        }

        $this->assertNotEmpty($customers);
    }

    public function test_create_customer(): void 
    {
        $user = User::factory()->create();
        $customer = self::repository()->create([
            'user_id' => $user->id,
            'first_name' => 'teste',
            'last_name' => 'teste',
            'phone' => '21995969977',
            'status' => '1',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now()
        ]);

        $this->assertNotEmpty($customer);
        $this->assertIsInt($customer->user_id);
    }

    public function test_update_customer(): void 
    {
        $user = User::factory()->create();
        $customer = self::repository()->create([
            'user_id' => $user->id,
            'first_name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'phone' => '21995969977',
            'status' => '1',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now()
        ]);
        $result = self::repository()->update($customer->user_id, ['first_name' => 'teste update']);
        $this->assertEquals($result, 1);
    }

    public function test_find_customer(): void 
    {
        $customer = Customer::query()->inRandomOrder()->first(['user_id']);
        $customer = self::repository()->find($customer->user_id);

        $this->assertNotEmpty($customer->user_id);
        $this->assertNotEmpty($customer->first_name);
    }

    public function test_delete_customer(): void 
    {
        $customer = Customer::query()->orderByDesc('user_id')->first(['user_id']);
        $result = self::repository()->delete($customer->user_id);

        $this->assertNotEmpty($result);
    }
}
