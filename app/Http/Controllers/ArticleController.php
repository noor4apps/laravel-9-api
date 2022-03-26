<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::paginate(10);
    }

    public function store(ArticleRequest $request)
    {
        $result = Article::create($request->all());

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Article created successfully'], 200);

        } else {
            return response()->json(['status' => 'error', 'message' => 'Article not created'], 405);
        }
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $result = $article->update($request->all());

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Article updated successfully'], 200);

        } else {
            return response()->json(['status' => 'error', 'message' => 'Article not updated'], 405);
        }
    }

    public function destroy(Article $article)
    {
        $result = $article->delete();

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Article deleted successfully'], 200);

        } else {
            return response()->json(['status' => 'error', 'message' => 'Article not deleted'], 405);
        }
    }
}
