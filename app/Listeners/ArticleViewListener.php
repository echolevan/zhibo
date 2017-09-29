<?php

namespace App\Listeners;

use App\Events\ArticleView;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Session\Store;
class ArticleViewListener
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
     * @param  ArticleView  $event
     * @return void
     */
    public function handle(ArticleView $event)
    {
        $post = $event->article;
        //先进行判断是否已经查看过
        if (!$this->hasViewedArticle($post)) {
            //保存到数据库
            $post->count = $post->count + 1;
            $post->save();
            //看过之后将保存到 Session
            $this->storeViewedArticle($post);
        }
    }

    protected function hasViewedArticle($post)
    {
        return array_key_exists($post->id, $this->getViewedArticles());
    }

    protected function getViewedArticles()
    {
        return $this->session->get('viewed_Articles', []);
    }

    protected function storeViewedArticle($post)
    {
        $key = 'viewed_Articles.'.$post->id;

        $this->session->put($key, time());
    }
}
