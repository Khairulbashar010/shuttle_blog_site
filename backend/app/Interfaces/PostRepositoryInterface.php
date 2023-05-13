<?php

namespace App\Interfaces;

interface PostRepositoryInterface
{
    public function getAllPosts();
    public function createPost(array $data);
    public function findPostBySlug($slug);
    public function findPostById($id);
    public function updatePost($id, array $data);
    public function deletePost($id);
}