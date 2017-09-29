<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\ArticleView' => [
            'App\Listeners\ArticleViewListener',
        ],
        'App\Events\LiveEvent'=>[
            'App\Listeners\LiveListener'
        ]
//        'SocialiteProviders\Manager\SocialiteWasCalled' => [
//            'SocialiteProviders\Weixin\WeixinExtendSocialite@handle',
//            'SocialiteProviders\QQ\QqExtendSocialite@handle',
//        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
