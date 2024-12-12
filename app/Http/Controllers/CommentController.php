<?php

namespace App\Http\Controllers;

use App\Filters\CommentFilter;
use App\Http\Requests\CommentFilterRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentListCollection;
use App\Jobs\ProcessComment;
use App\Models\Comment;

class CommentController extends Controller
{

    public function index(CommentFilterRequest $request, CommentFilter $filter)
    {
        $articles = Comment::filter($filter)
            ->orderBy('updated_at', 'desc')->get();
        return CommentListCollection::make($articles);
    }

    public function store(StoreCommentRequest $request)
    {
        $data = $request->validated();
        ProcessComment::dispatch($data);
        return response()->json(['message' => 'Комментарий будет обработан в фоновом режиме.'], 200);
    }
}
