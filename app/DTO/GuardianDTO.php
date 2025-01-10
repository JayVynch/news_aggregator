<?php

namespace App\DTO;

use App\Action\DateFormater;

class GuardianDTO
{
    public function __construct(
        public $section,
        public $title,
        public $url,
        public $published_at,
    ) 
    {
    }

    public static function transformData(
        $section,
        $title,
        $url,
        $published_date
    )
    {
        $published_at = DateFormater::prepareDate($published_date);

        return new static(
            $section,
            $title,
            $url,
            $published_at
        );
    }
}