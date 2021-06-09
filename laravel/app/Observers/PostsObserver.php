<?php

namespace App\Observers;

use App\Models\MuseumPost;
use App\Models\UserFavorites;
use App\Models\UserHistory;

class PostsObserver
{
    /**
     * Handle the = museum post "created" event.
     *
     * @param  \App\=MuseumPost  $=MuseumPost
     * @return void
     */
    public function created(MuseumPost $museumPost)
    {

    }

    /**
     * Handle the = museum post "updated" event.
     *
     * @param  \App\=MuseumPost  $=MuseumPost
     * @return void
     */
    public function updated(MuseumPost $museumPost)
    {
        //
    }

    /**
     * Handle the = museum post "deleted" event.
     *
     * @param  \App\=MuseumPost  $=MuseumPost
     * @return void
     */
    public function deleted(MuseumPost $museumPost)
    {
        //
    }

    /**
     * Handle the = museum post "restored" event.
     *
     * @param  \App\=MuseumPost  $=MuseumPost
     * @return void
     */
    public function restored(MuseumPost $museumPost)
    {
        //
    }

    /**
     * Handle the = museum post "force deleted" event.
     *
     * @param  \App\=MuseumPost  $=MuseumPost
     * @return void
     */
    public function forceDeleted(MuseumPost $museumPost)
    {
        if (!empty($museumPost->id)) {
            UserHistory::where('post_id', $museumPost->id)->forceDelete();
            UserFavorites::where('post_id', $museumPost->id)->forceDelete();
        }
    }
}
