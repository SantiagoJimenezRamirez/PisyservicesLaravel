<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductService
{
    public function add($productData)
    {
        try {
            $product = Product::create($productData);
            return $product;
        } catch (\Exception $e) {
            \Log::error("Error creating product: " . $e->getMessage());
            throw new \Exception("Error creating product");
        }
    }

    public function getAll()
    {
        try {
            return Product::all();
        } catch (\Exception $e) {
            \Log::error("Error retrieving products: " . $e->getMessage());
            throw new \Exception("Error retrieving products");
        }
    }

    public function getById($id)
    {
        try {
            return Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        } catch (\Exception $e) {
            \Log::error("Error retrieving product: " . $e->getMessage());
            throw new \Exception("Error retrieving product");
        }
    }

    public function update($id, $productData)
    {
        try {
            $product = Product::findOrFail($id);
            $product->update($productData);
            return $product;
        } catch (ModelNotFoundException $e) {
            return null;
        } catch (\Exception $e) {
            \Log::error("Error updating product: " . $e->getMessage());
            throw new \Exception("Error updating product");
        }
    }

    public function delete($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return true;
        } catch (ModelNotFoundException $e) {
            return null;
        } catch (\Exception $e) {
            \Log::error("Error deleting product: " . $e->getMessage());
            throw new \Exception("Error deleting product");
        }
    }
}
