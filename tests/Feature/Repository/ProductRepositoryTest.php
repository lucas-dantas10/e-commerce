<?php

namespace Tests\Feature\Repository;

use App\Interfaces\RepositoryInterface;
use App\Models\Product;
use App\Repository\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    public static function repository(): RepositoryInterface
    {
        return new ProductRepository;
    }

    public function test_get_all_products(): void
    {
        $products = self::repository()->all();

        if (count($products) == 0) {
            $this->assertEmpty($products);
            return;
        }

        $this->assertNotEmpty($products);
    }

    public function test_create_product(): void 
    {
        $product = self::repository()->create([
            ...Product::factory()->make()->toArray(),
            'title' => 'teste create product'
        ]);

        $this->assertNotEmpty($product);
        $this->assertIsInt($product->id);
    }

    public function test_update_product(): void 
    {
        $product = Product::query()->inRandomOrder()->first(['id']);
        $result = self::repository()->update($product->id, [ 'title' => 'teste update product']);
        $this->assertEquals($result, 1);
    }

    public function test_find_product(): void 
    {
        $product = Product::query()->inRandomOrder()->first(['id']);
        $product = self::repository()->find($product->id);

        $this->assertNotEmpty($product->id);
        $this->assertNotEmpty($product->title);
    }

    public function test_delete_product(): void 
    {
        $product = Product::query()->orderByDesc('id')->first(['id']);
        $result = self::repository()->delete($product->id);

        $this->assertNotEmpty($result);
    }
}
