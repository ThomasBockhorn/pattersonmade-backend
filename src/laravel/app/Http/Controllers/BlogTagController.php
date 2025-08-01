<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogTagStoreRequest;
use App\Http\Requests\BlogTagUpdateRequest;
use App\Http\Resources\BlogTagCollection;
use App\Http\Resources\BlogTagResource;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlogTagController extends Controller
{
    public function index(Request $request): BlogTagCollection
    {
        $blogTags = BlogTag::all();

        return new BlogTagCollection($blogTags);
    }

    public function store(BlogTagStoreRequest $request): BlogTagResource
    {
        $blogTag = BlogTag::create($request->validated());

        return new BlogTagResource($blogTag);
    }

    public function show(Request $request, BlogTag $blogTag): BlogTagResource
    {
        return new BlogTagResource($blogTag);
    }

    public function update(BlogTagUpdateRequest $request, BlogTag $blogTag): BlogTagResource
    {
        $blogTag->update($request->validated());

        return new BlogTagResource($blogTag);
    }

    public function destroy(Request $request, BlogTag $blogTag): Response
    {
        $blogTag->delete();

        return response()->noContent();
    }
}
