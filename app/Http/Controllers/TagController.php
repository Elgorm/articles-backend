<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagListCollection;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function index(Request $request)
    {
        $articles = Tag::orderBy('label', 'asc')->get();
        return TagListCollection::make($articles);
    }
}
