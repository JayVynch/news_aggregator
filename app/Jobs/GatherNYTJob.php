<?php

namespace App\Jobs;

use App\Action\MigrateNYT;
use App\Http\Services\NYTService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class GatherNYTJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(NYTService $nytService): void
    {
        $topics = [
            'arts',
            'home',
            'us',
            'world',
            'science'
        ];

        foreach($topics as $topic){
            $NYTNews = Cache::remember('newyorktimes', now()->addHours(30), fn() => $nytService->getStory($topic));
            
            (new MigrateNYT)($NYTNews);
        }
        
    }
}
