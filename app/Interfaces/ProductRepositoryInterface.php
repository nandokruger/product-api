<?php
namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getAllProducts();
    public function getProductById($id);
    public function getProductsByName($name);
    public function deleteProduct($id);
    public function createProduct(array $productDetails);
    public function updateProduct($id, array $newDetails);
    public function countProducts();
}