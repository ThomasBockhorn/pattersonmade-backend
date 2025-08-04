<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogTagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tagName' => $this->tagName,
            'blogPosts' => BlogPostCollection::make($this->whenLoaded('blogPosts')),
        ];
    }
}
