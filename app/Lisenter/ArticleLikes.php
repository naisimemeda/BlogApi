<?php

namespace App\Lisenter;

use App\Events\ArticleLike;
use App\Models\Like;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArticleLikes
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
     * @param  ArticleLike  $event
     * @return void
     */
    public function handle(ArticleLike $event)
    {
        $data = [
            'article_id' => $event->article_id,
            'user_id' => $event->user_id,
        ];
        Like::create($data);
    }
}
