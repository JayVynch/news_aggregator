<?php

namespace App\DTO;

use App\Action\DateFormater;

class NYTDTO
{
    public function __construct(
        public $section,
        public $title,
        public $abstract,
        public $url,
        public $author,
        public $published_at,
        public $images = []
    ) {
    }

    public static function transformData(
        $section,
        $title,
        $abstract,
        $url,
        $author,
        $published_date,
        $images
    )
    {
        $published_at = DateFormater::prepareDate($published_date);

        return new static(
            $section,
            $title,
            $abstract,
            $url,
            $author,
            $published_at,
            $images
        );
    }
}