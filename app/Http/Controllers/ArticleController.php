<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleListCollection;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Filters\ArticleFilter;
use App\Http\Requests\ArticleFilterRequest;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{

    public function index(ArticleFilterRequest $request, ArticleFilter $filter)
    {
        $sortBy = $request->get('sort_by', 'published_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $limit = $request->get('limit', 10);

        $articles = Article::filter($filter)
            ->with('tags')
            ->published()
            ->orderBy($sortBy, $sortOrder)
            ->paginate($limit);
        return ArticleListCollection::make($articles);
    }

    public function show($slug)
    {
        $article = Article::whereSlug($slug)->firstOrFail();

        if (is_null($article->published_at)) {
            abort(404, 'Статья не найдена');
        }

        $article->incrementStatsKey('views');
        return ArticleResource::make($article);
    }

    public function like(Article $article)
    {
        if (is_null($article->published_at)) {
            abort(404, 'Статья не найдена');
        }

        $article->incrementStatsKey('likes');
        return response()->json(['id' => $article->id, 'likes' => $article->getLikes()]);
    }
}
