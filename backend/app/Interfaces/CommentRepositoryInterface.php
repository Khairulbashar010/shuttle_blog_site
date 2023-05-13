<?php

namespace App\Interfaces;

interface CommentRepositoryInterface
{
    public function getCommentsByPostId($post_id);
    public function createComment($post_id, array $data);
    public function findCommentById($id);
    public function deleteComment($id);
}