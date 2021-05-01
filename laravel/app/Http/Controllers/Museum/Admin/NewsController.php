<?php

namespace App\Http\Controllers\Museum\Admin;

use App\Http\Controllers\Controller;
use App\Models\MuseumNews;
use App\Repositories\MuseumNewsRepository;
use App\Repositories\MuseumUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends BaseAdminController
{


    private $museumNewsRepository;
    private $museumUserRepository;


    public function __construct()
    {
        parent::__construct();

        $this->museumNewsRepository = app(MuseumNewsRepository::class);
        $this->museumUserRepository = app(MuseumUserRepository::class);
    }


    public function index()
    {
        $news = $this->museumNewsRepository->getAllWithPaginate();

        return view('museum.admin.news.index', compact('news'));
    }

    public function create()
    {
        $news = new MuseumNews();

        return view('museum.admin.news.create', compact('news'));
    }

    public function store(Request $request)
    {

        $data = $request->input();
        $data['user_id'] = Auth::id();

        $item = new MuseumNews($data);

        $result = $item->save();


        if ($result) {
            return response(['message' => 'Запись успешно создана', 'status' => 'OK', 'id' => $item['id']]);
        } else {
            return response(['message' => 'Ошибка сохранения, перепроверьте данные', 'status' => 'ERROR']);
        }
    }

    public function edit($id)
    {
        $news = $this->museumNewsRepository->getEdit($id);
        $user = $this->museumUserRepository->getUserBaseInfo($news->user_id);
        $news->user = $user;

        return view('museum.admin.news.edit')->with('news', $news);
    }

    public function update(Request $request, $id)
    {

        $item = $this->museumNewsRepository->getEdit($id);
        $data = $request->all();


        if (empty($item)) {
            return response(['message' => 'Сохраняемая новость не существует']);
        }

        $result = $item
            ->fill($data)
            ->save();


        if ($result) {
            return response(['message' => 'Успешно сохранено', 'status' => 'OK']);
        } else {
            return response(['message' => 'Ошибка сохранения, перепроверьте данные', 'status' => 'ERROR']);
        }


    }

    public function destroy($id)
    {

        $item = $this->museumNewsRepository->getEdit($id);
        $result = $item->forceDelete();

        if ($result) {
            return response(['message' => 'Успешно удалено', 'status' => 'OK']);
        } else {
            return response(['message' => 'Ошибка удаления', 'status' => 'ERROR']);
        }

    }
}
