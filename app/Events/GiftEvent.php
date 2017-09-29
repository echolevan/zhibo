<?php

namespace App\Events;

use App\Events\Event;
use App\Models\Gift_history;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GiftEvent extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Gift_history $gift_history)
    {
        $this->gift_history = $gift_history;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['gift'];
    }
    public function broadcastWith()
    {
        return [
            'name' => $this->gift_history->gift_name,
            'img' => $this->gift_history->gift->gift,
            'num' => $this->gift_history->num
        ];
    }

}
