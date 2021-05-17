<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserFavoritesRepository;
use App\Repositories\UserHistoryRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    private $userFavoritesRepository;
    private $userHistoryRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->userFavoritesRepository = app(UserFavoritesRepository::class);
        $this->userHistoryRepository = app(UserHistoryRepository::class);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \Auth::user();
        $userFavorites = json_encode($this->userFavoritesRepository->getUserFavorites($user->id));
        $userHistories = json_encode($this->userHistoryRepository->getHistories($user->id));

        return view('home', compact('user', 'userFavorites', 'userHistories'));
    }

    public function update(Request $request, $id) {

        $user = User::find($id);
        $data = $request->all();

            $result = $user->fill($data)->save();

            if ($result) {
                return response(['message' => 'Успешно сохранено', 'status' => 'OK', 'user' => $user]);
            } else {
                return response(['message' => 'Ошибка сохранения, перепроверьте данные', 'status' => 'ERROR']);
            }


    }
}
