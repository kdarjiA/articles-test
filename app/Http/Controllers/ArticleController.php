<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    const DEFAULT_PAGINATE=10;
    public function index()
    {
        $articles = Article::with(['primaryCategory'])->paginate(self::DEFAULT_PAGINATE)->onEachSide(0);
        $categories = Categories::all();
        return Response::json(['articles' => $articles,'categories'=>$categories]);
    }

    public function search()
    {
        $categories = Categories::all();
        $articles = Article::with(['primaryCategory'])->search(request())->paginate(self::DEFAULT_PAGINATE)->onEachSide(0);
        return Response::json(['articles' => $articles, 'categories' => $categories]);
    }


}
