<?php

namespace App\Action;

use App\DTO\NYTDTO;
use App\Models\News;
use App\Action\FormatDate;

class MigrateNYT
{

    public function __invoke($newyorkTimes)
    {
        $news = collect($newyorkTimes['results']);

        $news->chunk(10);

        foreach($news as $story){
            $NYTimesDTO = NYTDTO::transformData(
                $newyorkTimes['section'],
                $story['title'],
                $story['abstract'],
                $story['url'],
                $story['byline'],
                $story['published_date'],
                $story['multimedia']
            ); 

            News::insert([
                'source' => 'NewYorkTimes',
                'title' => $NYTimesDTO->title,
                'author' => $NYTimesDTO->author,
                'url' => $NYTimesDTO->url,
                'published_at' => $NYTimesDTO->published_at,
                'image' => json_encode($NYTimesDTO->images),
                'abstract' => $NYTimesDTO->abstract,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}