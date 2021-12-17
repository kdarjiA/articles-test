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
        $articles = Article::with(['primaryCategory'])->paginate(self::DEFAULT_PAGINATE);
        $categories = Categories::all();
        return Response::json(['articles' => $articles,'categories'=>$categories]);

    }

    public function search()
    {
        $category = \request()->get('category', null);
     /*   $articles = Article::has('articleCategories', '>', 1)->with(['articleCategories' => function ($query) use ($category) {
            return $query->where('category_id', $category);
        }])->paginate(self::DEFAULT_PAGINATE);*/

        //\DB::enableQueryLog();
        $articles = Article::search(request())->paginate(self::DEFAULT_PAGINATE);
        //dd(\DB::getQueryLog());
        return Response::json(['articles' => $articles]);

    }


}
