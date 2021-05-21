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

    public function fetchNewsMore()
    {
        $newsList = $this->museumNewsRepository->getLastNews();

        if (!empty($newsList)) {
            return response(['status' => 'OK', 'details' => $newsList]);
        } else {
            return response(['message' => 'Пока новостей больше нет', 'status' => 'OK']);
        }
    }
}
