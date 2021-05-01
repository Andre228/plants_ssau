<?php

namespace App\Http\Controllers\Museum;

use App\Http\Controllers\Controller;
use App\Repositories\MuseumNewsRepository;
use App\Repositories\MuseumPostRepository;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{

    private $museumPostRepository;
    private $museumNewsRepository;

    public function __construct()
    {
        $this->museumPostRepository = app(MuseumPostRepository::class);
        $this->museumNewsRepository = app(MuseumNewsRepository::class);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $newsList = $this->museumNewsRepository->getLastNews();
        $postsList = $this->museumPostRepository->getLastPublishedPosts(12);

        return view('welcome',  compact('newsList', 'postsList'));
    }
}
