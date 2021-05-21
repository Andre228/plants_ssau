<?php

namespace App\Http\Controllers\Museum;

use App\Models\UserFavorites;
use App\Models\User;
use App\Models\UserReadingNews;
use App\Repositories\MuseumUserRepository;
use App\Repositories\UserFavoritesRepository;
use App\Repositories\UserReadingRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Museum\BaseController as BaseController;

class UserController extends BaseController
{

    private $museumUserRepository;
    private $userFavoritesRepository;
    private $userReadingNewsRepository;


    public function __construct()
    {
        parent::__construct();

        $this->museumUserRepository = app(MuseumUserRepository::class);
        $this->userFavoritesRepository = app(UserFavoritesRepository::class);
        $this->userReadingNewsRepository = app(UserReadingRepository::class);
    }

    public function addToFavorites($userId, $postId)
    {
        $data [] = [
            'user_id' => $userId,
            'post_id' => $postId
        ];

        $item = new UserFavorites($data);
        $item->user_id = $userId;
        $item->post_id = $postId;
        $result = $item->save();

        $user = $this->museumUserRepository->getUserBaseInfo($userId)[0];


        if ($result) {
            return response(['message' => 'Добавлено в избранное', 'status' => 'OK', 'details' => $user]);
        } else {
            return response(['message' => 'Произошла ошибка', 'status' => 'ERROR']);
        }

    }

    public function addToReadingNews($userId, $newsId)
    {
        $data [] = [
            'user_id' => $userId,
            'news_id' => $newsId
        ];

        $item = new UserReadingNews($data);
        $item->user_id = $userId;
        $item->news_id = $newsId;
        $result = $item->save();

        $user = $this->museumUserRepository->getUserBaseInfo($userId)[0];

        if ($result) {
            return response(['message' => 'Добавлено в список для чтения', 'status' => 'OK', 'details' => $user]);
        } else {
            return response(['message' => 'Произошла ошибка', 'status' => 'ERROR']);
        }

    }

    public function removeFromFavorites($id)
    {

        $userFavorite = $this->userFavoritesRepository->getEdit($id);

        $result = $userFavorite->delete();


        if ($result) {
            return response(['message' => 'Удалено из избранного', 'status' => 'OK']);
        } else {
            return response(['message' => 'Произошла ошибка', 'status' => 'ERROR']);
        }

    }

    public function removeFromReadingList($id)
    {

        $userFavorite = $this->userReadingNewsRepository->getEdit($id);

        $result = $userFavorite->delete();


        if ($result) {
            return response(['message' => 'Удалено из списка для чтения', 'status' => 'OK']);
        } else {
            return response(['message' => 'Произошла ошибка', 'status' => 'ERROR']);
        }

    }


    public function getMoreFavorites($userId)
    {
        $userFavorites = $this->userFavoritesRepository->getUserFavorites($userId);

        if ($userFavorites) {
            return response(['status' => 'OK', 'details' => $userFavorites]);
        } else {
            return response(['status' => 'ERROR']);
        }

    }
}
