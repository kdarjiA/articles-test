<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'id';
    use HasFactory;

    public function primaryCategory()
    {
        return $this->hasOne(Categories::class,'id','primary_category_id');
    }

    public function articleCategories()
    {
        return $this->belongsToMany(Categories::class, 'articles_categories','article_id','category_id');

    }

    public function scopeSearch($query, $request)
    {

        $category_id = $request->get('category');
        $search_by = $request->get('search_by',null);

        return $query->Join('articles_categories', function ($join) use ($category_id) {
            $join->on('articles_categories.article_id', '=', 'articles.id')
                ->where('articles_categories.category_id', '=',$category_id);
        })->when($query != null, function ($query) use($search_by){
            return $query->where('title', 'like', "%$search_by%")->orWhere('content', 'like', "%$search_by%");

        });


    }


}
