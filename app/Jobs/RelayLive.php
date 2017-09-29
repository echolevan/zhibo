<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\LiveRelay;
use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RelayLive extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $relay;

    /**
     * Create a new job instance.
     *
     * @param LiveRelay $relay
     *
     * @return void
     */
    public function __construct(LiveRelay $relay)
    {
        $this->relay = $relay;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(empty($this->relay) || $this->relay->expired_at < Carbon::now()){
            $this->job->delete();
        }

        \Artisan::call('live:relay', [
            'relay_id' => $this->relay->id
        ]);
    }
}
