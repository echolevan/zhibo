<?php

namespace App\Listeners;

use App\Events\LiveEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Session\Store;
class LiveListener
{
    protected $session;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Handle the event.
     *
     * @param  liveEvent  $event
     * @return void
     */
    public function handle(liveEvent $event)
    {
        $post = $event->live_history;
        //先进行判断是否已经查看过
        if (!$this->hasLive($post)) {
            //保存到数据库
            $post->count = $post->count + 1;
            $post->save();
            //看过之后将保存到 Session
            $this->storeLive($post);
        }
    }

    protected function hasLive($post)
    {
        return array_key_exists($post->id, $this->getLives());
    }

    protected function getLives()
    {
        return $this->session->get('viewed_Lives', []);
    }

    protected function storeLive($post)
    {
        $key = 'viewed_Lives.'.$post->id;

        $this->session->put($key, time());
    }
}
