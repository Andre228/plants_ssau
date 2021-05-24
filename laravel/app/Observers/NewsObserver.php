<?php

namespace App\Observers;

use App\Models\MuseumNews;
use App\Models\MuseumNewsInfo;

class NewsObserver
{


    public function creating(MuseumNews $museumNews)
    {

    }
    /**
     * Handle the museum news "created" event.
     *
     * @param  \App\Models\MuseumNews  $museumNews
     * @return void
     */
    public function created(MuseumNews $museumNews)
    {
        $item = new MuseumNewsInfo();

        $item->news_id = $museumNews->id;
        $item->likes = 0;

        $result = $item->save();
    }

    /**
     * Handle the museum news "updated" event.
     *
     * @param  \App\Models\MuseumNews  $museumNews
     * @return void
     */
    public function updated(MuseumNews $museumNews)
    {
        //
    }

    /**
     * Handle the museum news "deleted" event.
     *
     * @param  \App\Models\MuseumNews  $museumNews
     * @return void
     */
    public function deleted(MuseumNews $museumNews)
    {
        //
    }

    /**
     * Handle the museum news "restored" event.
     *
     * @param  \App\Models\MuseumNews  $museumNews
     * @return void
     */
    public function restored(MuseumNews $museumNews)
    {
        //
    }

    /**
     * Handle the museum news "force deleted" event.
     *
     * @param  \App\Models\MuseumNews  $museumNews
     * @return void
     */
    public function forceDeleted(MuseumNews $museumNews)
    {
        //
    }
}
