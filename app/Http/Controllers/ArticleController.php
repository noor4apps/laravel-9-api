<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('user:id,name')->paginate(10);

        if ($articles) {
            return new ArticleCollection($articles);
        } else {
            return response()->api([], 1, 'something went wrong!');
        }
    }

    public function store(ArticleRequest $request)
    {
        $article = auth()->user()->articles()->create($request->all());

        if ($article) {
            return response()->api(new ArticleResource($article->load('user')), 0,'Article created successfully');

        } else {
            return response()->api([], 1, 'Article not created');
        }
    }

    public function update(ArticleRequest $request, $article)
    {
        $article = auth()->user()->articles()->find($article);

        if (!$article) {
            return response()->api([], 1, 'Article Not Found');
        }

        if ($article->update($request->all())) {
            return response()->api(new ArticleResource($article->load('user')), 0, 'Article updated successfully');

        } else {
            return response()->api([], 1, 'Article not updated');
        }
    }

    public function destroy($article)
    {
        $article = auth()->user()->articles()->find($article);

        if (!$article) {
            return response()->api([], 1, 'Article Not Found');
        }

        if ($article->delete()) {
            return response()->api([], 0, 'Article deleted successfully');

        } else {
            return response()->api([], 1, 'Article not deleted');
        }
    }

    public function user_articles()
    {
        $articles = auth()->user()->articles()->with('user:id,name')->paginate(10);

        if ($articles) {
            return new ArticleCollection($articles);
        } else {
            return response()->api([], 1, 'something went wrong!');
        }
    }
}
