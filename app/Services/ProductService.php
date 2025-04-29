<?php
namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAllProducts();
    }

    public function getProductById($id)
    {
        return $this->productRepository->getProductById($id);
    }

    public function getProductsByName($name)
    {
        return $this->productRepository->getProductsByName($name);
    }

    public function createProduct(array $productDetails)
    {
        return $this->productRepository->createProduct($productDetails);
    }

    public function updateProduct($id, array $newDetails)
    {
        return $this->productRepository->updateProduct($id, $newDetails);
    }

    public function deleteProduct($id)
    {
        return $this->productRepository->deleteProduct($id);
    }

    public function countProducts()
    {
        return $this->productRepository->countProducts();
    }
}