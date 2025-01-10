<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class NewsApiService
{
    private string $baseUrl = 'https://newsapi.org/v2/top-headlines';

    public function getStory($country="us",$category='business')
    {
        //for more options visit https://newsapi.org
        $response = Http::get("{$this->baseUrl}/", [
            'country' => $country,
            'category' => $category,
            'apiKey' => config('services.newsapi.api_key'),
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return response()->json(['message' => 'Could not get data from NewsApi'],433);
    }
}