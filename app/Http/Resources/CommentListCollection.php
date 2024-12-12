<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentListCollection extends ResourceCollection
{

    public function toArray(Request $request)
    {
        return [
            'data' => $this->collection->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'subject' => $comment->subject,
                    'body' => $comment->body,
                    'article_id' => $comment->article_id,
                    'created_at' => $comment->created_at,
                    'updated_at' => $comment->updated_at,
                ];
            }),
        ];
    }
}
