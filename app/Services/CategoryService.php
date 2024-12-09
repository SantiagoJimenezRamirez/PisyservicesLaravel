<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryService
{
    public function add($categoryData)
    {
        try {
            $category = Category::firstOrCreate(
                ['name' => $categoryData['name']],
                $categoryData
            );
            return $category;
        } catch (\Exception $e) {
            \Log::error("Error creating category: " . $e->getMessage());
            throw $e;
        }
    }

    public function getAll()
    {
        try {
            return Category::all();
        } catch (\Exception $e) {
            \Log::error("Error retrieving categories: " . $e->getMessage());
            throw new \Exception("Error retrieving categories");
        }
    }

    public function getById($id)
    {
        try {
            return Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        } catch (\Exception $e) {
            \Log::error("Error retrieving category: " . $e->getMessage());
            throw new \Exception("Error retrieving category");
        }
    }

    public function update($id, $categoryData)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update($categoryData);
            return $category;
        } catch (ModelNotFoundException $e) {
            return null;
        } catch (\Exception $e) {
            \Log::error("Error updating category: " . $e->getMessage());
            throw new \Exception("Error updating category");
        }
    }

    public function delete($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return true;
        } catch (ModelNotFoundException $e) {
            return null;
        } catch (\Exception $e) {
            \Log::error("Error deleting category: " . $e->getMessage());
            throw new \Exception("Error deleting category");
        }
    }
}
