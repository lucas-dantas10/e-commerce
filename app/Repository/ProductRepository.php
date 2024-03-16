<?php

namespace App\Repository;

use App\Models\Product;

class ProductRepository extends AbstractRepository
{
    protected static $model = Product::class;

    public function filterProducts(
        string $search, string $sortField, string $sortDirection, int $perPage
    ) {
        $query = Product::query()
            ->where('title', 'like', "%{$search}%")
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return $query;
    }
}
