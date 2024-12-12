<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleListCollection extends ResourceCollection
{

    public function toArray(Request $request)
    {
        return [
            'data' => $this->collection->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'short_content' => $article->short_content,
                    'slug' => $article->slug,
                    'photo_url' => $article->photo_url,
                    'cover_url' => $article->cover_url,
                    'views' => $article->getViews(),
                    'likes' => $article->getLikes(),
                ];
            }),
        ];
    }
}
