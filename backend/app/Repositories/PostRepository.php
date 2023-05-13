<?php

namespace App\Repositories;
use App\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


use App\Models\Tag;


use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{
    public function getAllPosts()
    {
        return Post::with('comments', 'tags', 'category')->orderBy('id', 'desc')->get();
    }

    public function createPost(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'blog_body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'blog_banner' => 'nullable|image|max:2048', // Maximum file size of 2MB (2048 kilobytes)
            'tags' => 'nullable|string',
        ]);
    
        if($validator->fails()) {
            throw new \Exception($validator->errors()->first(), 400);
        }

        $baseSlug = Str::slug($data['name']);
        $slug = $baseSlug;
        $counter = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $post = new Post();
        $post->name = $data['name'];
        $post->slug = $slug;
        $post->blog_body = $data['blog_body'];
        $post->category_id = $data['category_id'];
    
        if ($data['blog_banner']) {
            // Save the blog_banner
            $file = $data['blog_banner'];
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $fileName);
            $post->blog_banner = $fileName;
        }
    
        $post->save();
    
        // Attach the tags
        if (!empty($data['tags'])) {
            $tags = explode(',', $data['tags']);
            $tag_ids = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                $tag_ids[] = $tag->id;
            }
            $post->tags()->sync($tag_ids);
        }
    
        return $post;
    }

    public function findPostBySlug($slug)
    {
        return Post::with('comments', 'tags', 'category')->where('slug', $slug)->first();
    }

    public function findPostById($id)
    {
        return Post::with('comments', 'tags')->where('id', $id)->first();
    }

    public function updatePost($id, array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'blog_body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'blog_banner' => 'nullable|image|max:2048', // Maximum file size of 2MB (2048 kilobytes)
            'tags' => 'nullable|string',
        ]);

        if($validator->fails()) {
            throw new \Exception($validator->errors()->first(), 400);
        }

        $post = Post::where('id', $id)->first();
        // return public_path('images/');

        if(!$post) {
            throw new \Exception("Post does not exist.", 404);
        }

        if ($data['blog_banner']) {
            // Save the blog_banner
            $file = $data['blog_banner'];
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $fileName);
            // Delete previous file
            $previousFilePath = public_path('images/'.$post->blog_banner);

            // Check if the previous file exists and delete it
            if (File::exists($previousFilePath)) {
                File::delete($previousFilePath);
            }

            $post->blog_banner = $fileName;
        }

        $post->name = $data['name'];
        $post->blog_body = $data['blog_body'];
        $post->category_id = $data['category_id'];
        $post->save();
    
        // Attach the tags
        if (!empty($data['tags'])) {
            $tags = explode(',', $data['tags']);
            $tag_ids = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                $tag_ids[] = $tag->id;
            }
            $post->tags()->sync($tag_ids);
        }
    
        return $post;
    }

    public function deletePost($id)
    {
        $post = Post::where('id', $id)->first();
        if($post) {
            $post->comments()->delete();
            $post->tags()->detach();
            $post->delete();
            return true;
        }
        return false;
        
    }
}