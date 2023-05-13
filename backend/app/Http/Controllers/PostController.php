<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    private $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        try {
            $posts = $this->postRepository->getAllPosts();
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json($e->message(), $e->status);
        }
    }

    public function show($slug)
    {
        try {
            $post = $this->postRepository->findPostBySlug($slug);
            if ($post) {
                return response()->json($post);
            } else {
                return response()->json(['message' => 'Post not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json($e->message(), $e->status);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->only('name', 'blog_body', 'category_id', 'blog_banner', 'tags');
            $createdPost = $this->postRepository->createPost($data);

            return response()->json($createdPost, 201);
        } catch (\Exception $e) {
            return response()->json($e->message(), $e->status);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->only('name', 'blog_body', 'category_id', 'blog_banner', 'tags');
            $updatedPost = $this->postRepository->updatePost($id, $data);

            if ($updatedPost) {
                return response()->json($updatedPost);
            } else {
                return response()->json(['message' => 'Post not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json($e->message(), $e->status);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->postRepository->deletePost($id);
            if ($deleted) {
                return response()->json(['message' => 'Post deleted']);
            } else {
                return response()->json(['message' => 'Post not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json($e->message(), $e->status);
        }
    }
}


