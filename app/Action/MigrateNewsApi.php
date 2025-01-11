<?php

namespace App\Action;

use App\DTO\NewsApiDTO;
use App\Models\News;

class MigrateNewsApi
{

    public function __invoke($newsapi)
    {
       
        $newses = collect($newsapi['articles']);
        
        $newses->chunk(10);

        foreach($newses as $news){
            $newsApiDTO = NewsApiDTO::transformData(
                $news['title'],
                $news['description'],
                $news['content'],
                $news['url'],
                $news['author'],
                $news['publishedAt'],
                $news['urlToImage']
            ); 

            if(! News::query()->select('url')->where('url',$newsApiDTO->url)->exists()){
                News::insert([
                    'source' => 'newsapi',
                    'title' => $newsApiDTO->title,
                    'author' => $newsApiDTO->author,
                    'url' => $newsApiDTO->url,
                    'published_at' => $newsApiDTO->published_at,
                    'image' => json_encode($newsApiDTO->images),
                    'abstract' => $newsApiDTO->description,
                    'content' => $newsApiDTO->abstract,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        
            
        }
        
    }
}