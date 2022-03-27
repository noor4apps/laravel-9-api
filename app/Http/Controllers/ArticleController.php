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

//        return  ArticleResource::collection($articles);
        return new ArticleCollection($articles);
    }

    public function store(ArticleRequest $request)
    {
        $result = Article::create($request->all());

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Article created successfully', 'data' => new ArticleResource($result)], 200);

        } else {
            return response()->json(['status' => 'error', 'message' => 'Article not created', 'data' => []], 405);
        }
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $result = $article->update($request->all());

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Article updated successfully', 'data' => new ArticleResource($result)], 200);

        } else {
            return response()->json(['status' => 'error', 'message' => 'Article not updated', 'data' => []], 405);
        }
    }

    public function destroy(Article $article)
    {
        $result = $article->delete();

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Article deleted successfully', 'data' => []], 200);

        } else {
            return response()->json(['status' => 'error', 'message' => 'Article not deleted', 'data' => []], 405);
        }
    }
}
