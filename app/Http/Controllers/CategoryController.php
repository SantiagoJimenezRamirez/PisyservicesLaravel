<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Log;



class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function add(Request $request)
    {
        $name = $request->input('category');

        try {
            $category = $this->categoryService->add(['name' => $name]);

            if (!$category) {
                return response()->json(['msg' => 'Invalid Category'], 400);
            }

            return response()->json(['message' => 'Category created successfully!', 'category' => $category], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while creating the category.'], 500);
        }
    }

    public function getAll()
    {
        try {
            $categories = $this->categoryService->getAll();
            return response()->json(['ok' => true, 'categories' => $categories]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while retrieving categories.'], 500);
        }
    }

    public function getById($id)
    {
        try {
            $category = $this->categoryService->getById($id);

            if (!$category) {
                return response()->json(['msg' => 'Category not found'], 404);
            }

            return response()->json(['ok' => true, 'category' => $category]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while retrieving the category.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $name = $request->input('category');

        try {
            $updatedCategory = $this->categoryService->update($id, ['name' => $name]);

            if (!$updatedCategory) {
                return response()->json(['msg' => 'Unable to update category'], 400);
            }

            return response()->json(['message' => 'Category updated successfully!', 'category' => $updatedCategory]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while updating the category.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->categoryService->delete($id);

            if (!$deleted) {
                return response()->json(['msg' => 'Unable to delete category'], 400);
            }

            return response()->json(['message' => 'Category deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the category.'], 500);
        }
    }
}
