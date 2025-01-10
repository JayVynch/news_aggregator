<?php

namespace App\Action;

use App\DTO\GuardianDTO;
use App\Models\News;
use App\Action\FormatDate;

class MigrateTheGuardian
{

    public function __invoke($guardianNews)
    {
        $news = collect($guardianNews['response']['results']);

        $news->chunk(10);

        foreach($news as $story){
            $guardianDTO = GuardianDTO::transformData(
                $story['sectionName'],
                $story['webTitle'],
                $story['webUrl'],
                $story['webPublicationDate'],
            ); 

            News::insert([
                'source' => 'theGuardian',
                'title' => $guardianDTO->title,
                'url' => $guardianDTO->url,
                'published_at' => $guardianDTO->published_at,
                'category' => $guardianDTO->section,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}