<?php

namespace App\Repositories;
use App\Interfaces\TagRepositoryInterface;
use Illuminate\Support\Facades\Validator;

use App\Models\Tag;

class TagRepository implements TagRepositoryInterface
{
    public function getAllTags()
    {
        return Tag::all();
    }

    public function createTag(array $data)
    {
        $tag = new Tag();
        $tag->name = $data['name'];
        $tag->save();

        return $tag;
    }

    public function findTagByName($name)
    {
        return Tag::where('name', $name)->first();
    }

    public function updateTag($id, array $data)
    {
        $tag = Tag::find($id);
        $tag->name = $data['name'];
        $tag->save();

        return $tag;
    }

    public function deleteTag($id)
    {
        $tag = Tag::find($id);
        if($tag) {
            $tag->delete();
            return true;
        }
        return false;
    }
}