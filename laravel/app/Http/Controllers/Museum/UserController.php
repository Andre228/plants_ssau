<?php

namespace App\Http\Controllers\Museum;

use App\Http\Controllers\Controller;
use App\Models\UserFavorites;
use App\Repositories\MuseumUserRepository;
use App\Repositories\UserFavoritesRepository;
use Illuminate\Http\Request;

class UserController extends BaseController
{

    private $museumUserRepository;
    private $userFavoritesRepository;


    public function __construct()
    {
        parent::__construct();

        $this->museumUserRepository = app(MuseumUserRepository::class);
        $this->userFavoritesRepository = app(UserFavoritesRepository::class);
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
}
