<?php

namespace App\Jobs;

use App\Action\MigrateNewsApi;
use App\Action\MigrateNYT;
use App\Action\MigrateTheGuardian;
use App\Http\Services\GuardianService;
use App\Http\Services\NewsApiService;
use App\Http\Services\NYTService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class GatherNews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     */
    public function handle(NewsApiService $newsApiService): void
    {
        $newsapi = Cache::remember('newsapi_articles',now()->addHours(24),fn() => $newsApiService->getStory());
    
        (new MigrateNewsApi)($newsapi);
    }
}
