<?php

namespace App\Http\Controllers\Museum\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\MuseumUserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class UserController extends BaseAdminController
{

    private $museumUserRepository;

    public function __construct()
    {
        parent::__construct();

        $this->museumUserRepository = app(MuseumUserRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->museumUserRepository->getAllWithPaginate(15);

        return view('museum.admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->museumUserRepository->getEdit($id);

        if(empty($item)) {
            return back(['msg' => 'Запись не найдена']);
        }

        return view('museum.admin.user.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = $this->museumUserRepository->getEdit($id);
        $data = $request->all();


        if (empty($item)) {
            return response(['message' => 'Сохраняемая пользователь не существует']);
        }

        $result = User::where('id', '=', $id)->update($data);

        if ($result) {
            return response(['message' => 'Успешно сохранено', 'status' => 'OK']);
        } else {
            return response(['message' => 'Ошибка сохранения, перепроверьте данные', 'status' => 'ERROR']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function getUsersOnPage()
    {

    }

    public function search(Request $request)
    {
        $search = $request->search;
        $users = $this->museumUserRepository->getSearchingUsers($request->search);

        return view('museum.admin.user.index', compact('users', 'search'));
    }
}
