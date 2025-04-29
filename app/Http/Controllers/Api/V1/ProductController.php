<?php
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return response()->json(['data' => $products], Response::HTTP_OK);
    }

    public function show($id)
    {
        try {
            $product = $this->productService->getProductById($id);
            return response()->json(['data' => $product], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100',
        ]);

        $product = $this->productService->createProduct($validated);
        return response()->json(['data' => $product], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'price' => 'sometimes|numeric|min:0',
                'stock' => 'sometimes|integer|min:0',
                'category' => 'nullable|string|max:100',
            ]);

            $this->productService->updateProduct($id, $validated);
            $product = $this->productService->getProductById($id);
            return response()->json(['data' => $product], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id)
    {
        try {
            $this->productService->deleteProduct($id);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function findByName($name)
    {
        $products = $this->productService->getProductsByName($name);
        return response()->json(['data' => $products], Response::HTTP_OK);
    }

    public function count()
    {
        $count = $this->productService->countProducts();
        return response()->json(['count' => $count], Response::HTTP_OK);
    }
}