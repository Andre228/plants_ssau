<?php

namespace App\Http\Controllers\Museum;

use App\Http\Controllers\Controller;
use App\Models\UserReadingNews;
use App\Repositories\MuseumNewsRepository;
use App\Repositories\MuseumPostRepository;
use App\Repositories\MuseumUserRepository;
use App\Repositories\UserFavoritesRepository;
use App\Repositories\UserReadingRepository;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{

    private $museumPostRepository;
    private $museumNewsRepository;
    private $museumUserRepository;
    private $userReadingNewsRepository;

    public function __construct()
    {
        $this->museumPostRepository = app(MuseumPostRepository::class);
        $this->museumNewsRepository = app(MuseumNewsRepository::class);
        $this->userReadingNewsRepository = app(UserReadingRepository::class);
        $this->museumUserRepository = app(MuseumUserRepository::class);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $newsList = $this->museumNewsRepository->getLastNews();
        $postsList = $this->museumPostRepository->getLastPublishedPosts(12);
        $userId = \Auth::id();
        $user = json_encode($this->museumUserRepository->getUserBaseInfo($userId));

        return view('welcome',  compact('newsList', 'postsList', 'user'));
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
