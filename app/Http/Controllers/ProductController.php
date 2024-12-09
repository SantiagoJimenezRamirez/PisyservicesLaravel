<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Models\Product;


class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function create(Request $request)
{

    $name = $request->input('name');
    $price = $request->input('price');
    $description = $request->input('description');
    $category = $request->input('category'); // Capturando la categoría
    $imagePath = $request->file('image') ? $request->file('image')->storeAs('public/storage') : null;

    if (!$imagePath) {
        return response()->json(['message' => 'Image file is required'], 400);
    }

    $productData = [
        'name' => $name,
        'price' => $price,
        'description' => $description,
        'category' => $category, // Incluyendo la categoría
        'imagePath' => $imagePath
    ];

    try {
        $product = $this->productService->add($productData);

        if (!$product) {
            return response()->json(['message' => 'Invalid Product'], 400);
        }

        return response()->json(['message' => 'Product created successfully!', 'product' => $product], 201);
    } catch (\Exception $e) {
        return response()->json(['message' => 'An error occurred while creating the product.'], 500);
    }
}



    public function getAll()
    {
        try {
            $products = $this->productService->getAll();
            return response()->json(['ok' => true, 'products' => $products]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while retrieving products.'], 500);
        }
    }

    public function getAllWithImg(Request $request)
    {
        try {
            // Obtener todos los productos (puedes usar Eloquent o Query Builder según tu caso)
            $products = Product::all();

            // Construir la URL base para las imágenes
            $baseUrl = $request->getSchemeAndHttpHost(); // Obtener el esquema y host actual

            // Crear un nuevo array con las URLs de las imágenes generadas
            $productsWithUrls = $products->map(function ($product) use ($baseUrl) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'imageUrl' => $product->imagePath 
                        ? "{$baseUrl}/uploads/public/products/" . basename($product->imagePath)
                        : "{$baseUrl}/uploads/public/products/default-image.png",
                ];
            });

            // Enviar la respuesta con las imágenes y los productos
            return response()->json(['ok' => true, 'products' => $productsWithUrls], 200);
        } catch (\Exception $error) {
            // En caso de error, registrar y responder con un mensaje
            return response()->json(['message' => 'An error occurred while retrieving products.'], 500);
        }
    }

    public function getById($id)
    {
        try {
            $product = $this->productService->getById($id);

            if (!$product) {
                return response()->json(['msg' => 'Product not found'], 404);
            }

            return response()->json(['ok' => true, 'product' => $product]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while retrieving the product.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $name = $request->input('object.name');
        $price = $request->input('object.price');
        $description = $request->input('object.description');
        $category = $request->input('object.category'); // Nuevo campo de categoría

        try {
            $updatedProduct = $this->productService->update($id, [
                'name' => $name,
                'price' => $price,
                'description' => $description,
                'category' => $category // Añadir la categoría aquí
            ]);

            if (!$updatedProduct) {
                return response()->json(['msg' => 'Unable to update product'], 400);
            }

            return response()->json(['message' => 'Product updated successfully!', 'product' => $updatedProduct]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while updating the product.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->productService->delete($id);

            if (!$result) {
                return response()->json(['msg' => 'Product not found'], 404);
            }

            return response()->json(['message' => 'Product deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the product.'], 500);
        }
    }
}
