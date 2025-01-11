<?php

namespace App\Jobs;

use App\Action\MigrateTheGuardian;
use App\Http\Services\GuardianService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class GatherGuardianNewsJob implements ShouldQueue
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
    public function handle(GuardianService $guardianService): void
    {
        $gaurdianNews = Cache::remember('the_guardian', now()->addHours(5), fn() => $guardianService->getStory());
        (new MigrateTheGuardian)($gaurdianNews);
    }
}
