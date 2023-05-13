<?php

namespace App\Interfaces;

interface TagRepositoryInterface
{
    public function getAllTags();
    public function createTag(array $data);
    public function findTagByName($name);
    public function updateTag($id, array $data);
    public function deleteTag($id);
}
