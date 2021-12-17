<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $fillable = ['category_name'];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'articles_categories','category_id','article_id');
    }

}
