<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimonialStoreRequest;
use App\Http\Requests\TestimonialUpdateRequest;
use App\Http\Resources\TestimonialCollection;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestimonialController extends Controller
{
    public function index(Request $request): TestimonialCollection
    {
        $testimonials = Testimonial::all();

        return new TestimonialCollection($testimonials);
    }

    public function store(TestimonialStoreRequest $request): TestimonialResource
    {
        $testimonial = Testimonial::create($request->validated());

        return new TestimonialResource($testimonial);
    }

    public function show(Request $request, Testimonial $testimonial): TestimonialResource
    {
        return new TestimonialResource($testimonial);
    }

    public function update(TestimonialUpdateRequest $request, Testimonial $testimonial): TestimonialResource
    {
        $testimonial->update($request->validated());

        return new TestimonialResource($testimonial);
    }

    public function destroy(Request $request, Testimonial $testimonial): Response
    {
        $testimonial->delete();

        return response()->noContent();
    }
}
