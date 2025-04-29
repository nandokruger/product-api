<?php
namespace App\Repositories;
use App\Models\Product;
use App\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts()
    {
        return Product::all();
    }

    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }

    public function getProductsByName($name)
    {
        return Product::where('name', 'like', "%{$name}%")->get();
    }

    public function deleteProduct($id)
    {
        return Product::destroy($id);
    }

    public function createProduct(array $productDetails)
    {
        return Product::create($productDetails);
    }

    public function updateProduct($id, array $newDetails)
    {
        return Product::whereId($id)->update($newDetails);
    }

    public function countProducts()
    {
        return Product::count();
    }
}