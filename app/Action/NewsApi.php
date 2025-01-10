<?php
namespace App\Action;

class NewsApi
{
    // testing endpoints with api keys
    public static function newsApi(): string
    {
        return 'https://newsapi.org/v2/top-headlines?country=us&category=business&apiKey=194b0386f54b416384fce2806b63d7de';
    }

    public static function guardian(): string
    {
        return 'https://content.guardianapis.com/search?api-key=17f2b20a-3a3f-4cf1-aec5-3852d70d6c2f';
    }

    public static function NYT(): string
    {
        return 'https://api.nytimes.com/svc/topstories/v2/world.json?api-key=uGNTATrkhrCkkrucXMqzsMYXZYSBdRI9';
    }
}