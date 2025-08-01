<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectTagStoreRequest;
use App\Http\Requests\ProjectTagUpdateRequest;
use App\Http\Resources\ProjectTagCollection;
use App\Http\Resources\ProjectTagResource;
use App\Models\ProjectTag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectTagController extends Controller
{
    public function index(Request $request): ProjectTagCollection
    {
        $projectTags = ProjectTag::all();

        return new ProjectTagCollection($projectTags);
    }

    public function store(ProjectTagStoreRequest $request): ProjectTagResource
    {
        $projectTag = ProjectTag::create($request->validated());

        return new ProjectTagResource($projectTag);
    }

    public function show(Request $request, ProjectTag $projectTag): ProjectTagResource
    {
        return new ProjectTagResource($projectTag);
    }

    public function update(ProjectTagUpdateRequest $request, ProjectTag $projectTag): ProjectTagResource
    {
        $projectTag->update($request->validated());

        return new ProjectTagResource($projectTag);
    }

    public function destroy(Request $request, ProjectTag $projectTag): Response
    {
        $projectTag->delete();

        return response()->noContent();
    }
}
