<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TagListCollection extends ResourceCollection
{

    public function toArray(Request $request)
    {
        return [
            'data' => $this->collection->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'label' => $tag->label,
                ];
            }),
        ];
    }
}
