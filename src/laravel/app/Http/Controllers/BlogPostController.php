<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogPostStoreRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Http\Resources\BlogPostCollection;
use App\Http\Resources\BlogPostResource;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlogPostController extends Controller
{
    public function index(Request $request): BlogPostCollection
    {
        $blogPosts = BlogPost::all();

        return new BlogPostCollection($blogPosts);
    }

    public function store(BlogPostStoreRequest $request): BlogPostResource
    {
        $blogPost = BlogPost::create($request->validated());

        return new BlogPostResource($blogPost);
    }

    public function show(Request $request, BlogPost $blogPost): BlogPostResource
    {
        return new BlogPostResource($blogPost);
    }

    public function update(BlogPostUpdateRequest $request, BlogPost $blogPost): BlogPostResource
    {
        $blogPost->update($request->validated());

        return new BlogPostResource($blogPost);
    }

    public function destroy(Request $request, BlogPost $blogPost): Response
    {
        $blogPost->delete();

        return response()->noContent();
    }
}
