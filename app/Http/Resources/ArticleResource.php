<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'tags' => $this->tags,
            'published_at' => $this->published_at,
            'photo_url' => $this->photo_url,
            'views' => $this->getViews(),
            'likes' => $this->getLikes(),
            'slug' => $this->slug,
        ];
    }
}
