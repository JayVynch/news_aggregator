<?php

namespace App\DTO;

use App\Action\DateFormater;

class NewsApiDTO
{
    public function __construct(
        public $title,
        public $description,
        public $abstract,
        public $url,
        public $author,
        public $published_at,
        public $images
    ) {
    }

    public static function transformData(
        $title,
        $description,
        $abstract,
        $url,
        $author,
        $published_date,
        $images
    )
    {
        $published_at = DateFormater::prepareDate($published_date);

        return new static(
            $title,
            $description,
            $abstract,
            $url,
            $author,
            $published_at,
            $images
        );
    }
}