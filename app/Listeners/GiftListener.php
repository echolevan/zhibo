<?php

namespace App\Listeners;

use App\Events\GiftEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GiftListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  GiftEvent  $event
     * @return void
     */
    public function handle(GiftEvent $event)
    {
        //
    }
}
