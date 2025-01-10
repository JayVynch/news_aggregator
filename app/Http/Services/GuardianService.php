<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class GuardianService
{
    private string $baseUrl = 'https://content.guardianapis.com';
    
    public function getStory($section='news')
    {
        $response = Http::get("{$this->baseUrl}/search", [
            'api-key' => config('services.guardian.api_key'),
            'section' => $section, // Fetch stories from the "news","sports" section
            // 'show-fields' => 'headline,trailText,webPublicationDate',
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return response()->json(['message' => 'Could not get data from Guardian'],433);
    }
}