<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path() . "/json/feed.json";
        $json_data = json_decode(file_get_contents($path), true);
        /*  $categories = [];
          $articles = [];
          $media_urls = [];
          foreach ($json_data as $index=>$data) {
              if (!empty($data['media'])) {
                  foreach ($data['media'] as $media) {
                      if (!empty($media['media']['attributes']) && !in_array($media['media']['attributes']['url'], $media_urls)) {
                          $media_urls[] = ['media_url' => $media['media']['attributes']['url']];
                      }
                  }
              }
              if (!empty($data['categories'])) {
                  if (!empty($data['categories']['primary']) && !in_array($data['categories']['primary'],$categories)) {
                      $categories[] = ['category_name'=>$data['categories']['primary']];
                  }
                  if (!empty($data['categories']['additional'])) {
                      foreach ($data['categories']['additional'] as $cat) {
                          if (!in_array($cat, $categories)) {
                              $categories[] =  ['category_name'=>$cat] ;
                          }
                      }
                  }
              }
          }
          \App\Models\Categories::insert($categories);
          \App\Models\media::insert($media_urls);
          die;*/


        foreach ($json_data as $index => $data) {
            $content = !empty($data['content']) ? $data['content'][0]['content'] : '';
            $article = new \App\Models\Article();
            $article->title = $data['title'];
            $article->slug = $data['slug'];
            $article->content = $content;
            $article->primary_category_id = null;
            $article->save();
            $article_id = $article->id;
            if (!empty($data['categories'])) {
                if (!empty($data['categories']['primary'])) {
                    $category = \App\Models\Categories::firstOrCreate(['category_name' => $data['categories']['primary']]);
                    $primary_category_id = $category->id;
                    DB::table('articles_categories')->insert(array('article_id' => $article_id, 'category_id' => $primary_category_id));
                }
                if (!empty($data['categories']['additional'])) {
                    foreach ($data['categories']['additional'] as $cat) {
                        $category = \App\Models\Categories::firstOrCreate(['category_name' => $cat]);
                        $additional_category_id = $category->id;
                        DB::table('articles_categories')->insert(array('article_id' => $article_id, 'category_id' => $additional_category_id));
                    }
                }
                $category_name = !empty($data['categories']['primary']) ? $data['categories']['primary'] : $data['categories']['additional'][0];
                $category_id = \App\Models\Categories::where('category_name', $category_name)->pluck('id')->first();
                $category_id = !empty($category_id) ? $category_id : null;
                \App\Models\Article::where('id', $article_id)->update(['primary_category_id' => $category_id]);
            }
            if (!empty($data['media'])) {
                foreach ($data['media'] as $media) {
                    if (!empty($media['media']['attributes'])) {
                        $media_object = new \App\Models\media();
                        $media_object->media_url = $media['media']['attributes']['url'];
                        $media_object->save();
                        $media_id = $media_object->id;
                        DB::table('media_article')->insert(array('article_id' => $article_id, 'media_id' => $media_id));
                    }
                }
            }
        }
    }
}
