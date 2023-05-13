<?php

namespace App\Repositories;

use App\Models\Category;
use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllCategories()
    {
        return Category::all();
    }

    public function getCategoryById($id)
    {
        return Category::find($id);
    }

    public function createCategory($name)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
        ]);
    
        if($validator->fails()) {
            throw new \Exception($validator->errors()->first(), 400);
        }
        return Category::create([
            'name' => $name
        ]);
    }

    public function updateCategory($id, $name)
    {
        $category = Category::find($id);
        if ($category) {
            $category->name = $name;
            $category->save();
        }
        return $category;
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            // Retrieve all posts associated with the category
            $posts = $category->posts;

            // Delete comments associated with each post
            foreach ($posts as $post) {
                $post->comments()->delete();
            }

            // Delete the posts
            $category->posts()->delete();

            // Delete the category
            $category->delete();
            return true;
        }
        return false;
    }
}