<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    public function getAllCategories();
    public function getCategoryById($id);
    public function createCategory($name);
    public function updateCategory($id, $name);
    public function deleteCategory($id);
}
