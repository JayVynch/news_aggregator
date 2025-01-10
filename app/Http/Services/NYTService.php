<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class NYTService
{
    private string $baseUrl = 'https://api.nytimes.com/svc';
    
    public function getStory($section = 'world')
    {
        $response = Http::get("{$this->baseUrl}/topstories/v2/{$section}.json", [
            'api-key' => config('services.nyt.api_key'),
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return response()->json(['message' => 'Could not get data from NewYorkTimes'],433);
    }
}