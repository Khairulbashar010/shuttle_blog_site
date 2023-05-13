<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Interfaces\CommentRepositoryInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    private $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(Request $request, $post_id)
    {
        try {
            $data = $request->only('name', 'comment', 'parent_id');
            $createdComment = $this->commentRepository->createComment($post_id, $data);

            return response()->json($createdComment, 201);
        } catch (\Exception $e) {
            return response()->json(['error'=>$e->getMessage()], $e->getCode());
        }
    }

    public function index($post_id)
    {
        try {
            $comments = $this->commentRepository->getCommentsByPostId($post_id);
            return response()->json($comments);
        } catch (\Exception $e) {
            return response()->json(['error'=>$e->getMessage()], $e->getCode());
        }
    }

    public function show($id)
    {
        try {
            $comment = $this->commentRepository->getCommentById($id);
            if ($comment) {
                return response()->json($comment);
            } else {
                return response()->json(['message' => 'Comment not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error'=>$e->getMessage()], $e->getCode());
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->commentRepository->deleteComment($id);

            if ($deleted) {
                return response()->json(['message' => 'Comment deleted']);
            } else {
                return response()->json(['message' => 'Comment not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error'=>$e->getMessage()], $e->getCode());
        }
    }
}

