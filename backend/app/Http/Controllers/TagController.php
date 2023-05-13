<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Interfaces\TagRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TagController extends Controller
{
    private $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function index()
    {
        try {
            $tags = $this->tagRepository->getAllTags();
            return response()->json($tags);
        } catch (\Exception $e) {
            return response()->json($e->message(), $e->status);
        }
    }

    public function show($name)
    {
        try {
            $tag = $this->tagRepository->findTagByName($name);
            if ($tag) {
                return response()->json($tag);
            } else {
                return response()->json(['message' => 'Tag not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json($e->message(), $e->status);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->only('name');
            $createdTag = $this->tagRepository->createTag($data['name']);

            return response()->json($createdTag, 201);
        } catch (\Exception $e) {
            return response()->json($e->message(), $e->status);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->only('name');

            $updatedTag = $this->tagRepository->updateTag($id, $data['name']);

            if ($updatedTag) {
                return response()->json($updatedTag);
            } else {
                return response()->json(['message' => 'Tag not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json($e->message(), $e->status);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->tagRepository->deleteTag($id);
            if ($deleted) {
                return response()->json(['message' => 'Tag deleted']);
            } else {
                return response()->json(['message' => 'Tag not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json($e->message(), $e->status);
        }
    }
}

