<?php

namespace App\Repositories;
use App\Interfaces\CommentRepositoryInterface;

use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use App\Repositories\PostRepository;


class CommentRepository implements CommentRepositoryInterface
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }


    public function getCommentsByPostId($post_id)
    {
        return Comment::where('post_id', $post_id)->with('replies')->get();
    }

    public function createComment($post_id, array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'comment' => 'required|string',
        ]);
    
        if($validator->fails()) {
            throw new \Exception($validator->errors()->first(), 400);
        }

        $post_exists = $this->postRepository->findPostById($post_id);
        if(!$post_exists) { 
            throw new \Exception("The post does not exist.", 400);
              
        }

        if(isset($data['parent_id'])) {
            $comment_exists = $this->findCommentById($data['parent_id']);
            if(!$comment_exists || ($comment_exists->post_id != $post_id)) {
                throw new \Exception("The comment does not exist.", 400);
            }
            if(!!$comment_exists->parent_id) {
                throw new \Exception("Cannot reply to a reply.", 400);
            }
        }
        $comment = new Comment();
        $comment->post_id = $post_id;
        $comment->name = $data['name'];
        $comment->comment_body = $data['comment'];
        $comment->parent_id = isset($data['parent_id']) ? $data['parent_id'] : null;
        $comment->save();

        return $comment;
    }

    public function findCommentById($id)
    {
        return Comment::with('replies')->find($id);
    }

    public function deleteComment($id)
    {
        $comment = Comment::find($id);
        if($comment) {
            $comment->replies()->delete();
            $comment->delete();
            return true;
        }
        return false;
    }
}