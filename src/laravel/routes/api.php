<?php

use Illuminate\Support\Facades\Route;


Route::apiResource('blog-posts', App\Http\Controllers\BlogPostController::class);

Route::apiResource('project-tags', App\Http\Controllers\ProjectTagController::class);

Route::apiResource('blog-tags', App\Http\Controllers\BlogTagController::class);

Route::apiResource('projects', App\Http\Controllers\ProjectController::class);

Route::apiResource('testimonials', App\Http\Controllers\TestimonialController::class);
