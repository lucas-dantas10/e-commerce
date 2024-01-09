<?php

namespace App\Services\Product;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Repository\ProductRepository;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {
    }

    public function filterByProducts()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');


        $query = $this->productRepository->filterProducts(
            search: $search,
            sortField: $sortField,
            sortDirection: $sortDirection,
            perPage: $perPage
        );

        return $query;
    }

    public function saveProduct(array $data, ProductRequest $request): Product
    {
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        $image = $data['image'] ?? null;

        if ($image) {
            $relativePath = $this->saveImage($image);
            $data['image'] = URL::to(Storage::url($relativePath));
            $data['image_mime'] = $image->getClientMimeType();
            $data['image_size'] = $image->getSize();
        }

        $product = $this->productRepository->create($data);

        return $product;
    }

    public function updateProduct(array $data, ProductRequest $request, int $id)
    {
        $data['updated_by'] = $request->user()->id;

        $product = $this->productRepository->find($id);

        $image = $data['image'] ?? null;

        if ($image) {
            $relativePath = $this->saveImage($image);
            $data['image'] = URL::to(Storage::url($relativePath));
            $data['image_mime'] = $image->getClientMimeType();
            $data['image_size'] = $image->getSize();

            if ($product->image) {
                Storage::deleteDirectory(dirname($product->image));
            }
        }

        $this->productRepository->update($product->id, $data);

        return $product;
    }

    private function saveImage(UploadedFile $image)
    {
        $path = 'images/' . Str::random();

        if (!Storage::exists($path)) {
            Storage::makeDirectory($path, 0755, true);
        }

        if (!Storage::putFileAs($path, $image, $image->getClientOriginalName())) {
            throw new Exception("Incapaz de salvar o arquivo {$image->getClientOriginalName()}");
        }

        return $path . '/' . $image->getClientOriginalName();
    }
}
