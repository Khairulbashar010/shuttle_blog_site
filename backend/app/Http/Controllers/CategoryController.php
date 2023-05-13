<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        try {
            $categories = $this->categoryRepository->getAllCategories();
            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json($e->message(), $e->status);
        }
    }

    public function show($id)
    {
        try {
            $category = $this->categoryRepository->getCategoryById($id);
            if ($category) {
                return response()->json($category);
            } else {
                return response()->json(['message' => 'Category not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json($e->message(), $e->status);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->only('name');
            $createdCategory = $this->categoryRepository->createCategory($data['name']);

            return response()->json($createdCategory, 201);
        } catch (\Exception $e) {
            return response()->json($e->message(), $e->status);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->only('name');
            $updatedCategory = $this->categoryRepository->updateCategory($id, $data['name']);
            if ($updatedCategory) {
                return response()->json($updatedCategory);
            } else {
                return response()->json(['message' => 'Category not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json($e->message(), $e->status);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->categoryRepository->deleteCategory($id);
            if ($deleted) {
                return response()->json(['message' => 'Category deleted']);
            } else {
                return response()->json(['message' => 'Category not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json($e->message(), $e->status);
        }
    }
}
