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
//        $request->merge(['user_id' => auth()->user()->id]);
//        $result = Article::create($request->all());

        $article = auth()->user()->articles()->create($request->all());

        if ($article) {
            return response()->json(['status' => 'success', 'message' => 'Article created successfully', 'data' => new ArticleResource($article->load('user'))], 200);

        } else {
            return response()->json(['status' => 'error', 'message' => 'Article not created', 'data' => []], 405);
        }
    }

    public function update(ArticleRequest $request, $article)
    {
//        $result = $article->update($request->all());
        $article = auth()->user()->articles()->find($article);

        if (!$article) {
            return response()->json(['status' => 'error', 'message' => 'Article Not Found', 'data' => []], 404);
        }

        if ($article->update($request->all())) {
            return response()->json(['status' => 'success', 'message' => 'Article updated successfully', 'data' => new ArticleResource($article->load('user'))], 200);

        } else {
            return response()->json(['status' => 'error', 'message' => 'Article not updated', 'data' => []], 405);
        }
    }

    public function destroy($article)
    {
        $article = auth()->user()->articles()->find($article);

        if (!$article) {
            return response()->json(['status' => 'error', 'message' => 'Article Not Found', 'data' => []], 404);
        }

        if ($article->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Article deleted successfully', 'data' => []], 200);

        } else {
            return response()->json(['status' => 'error', 'message' => 'Article not deleted', 'data' => []], 405);
        }
    }
}
