<?php

namespace App\Http\Controllers\Museum\Admin;

use App\Http\Controllers\Controller;
use App\Models\MuseumCategory;
use App\Models\MuseumPost;
use App\Repositories\MuseumCategoryRepository;
use App\Repositories\MuseumPostRepository;
use Illuminate\Http\Request;

class PostController extends BaseAdminController
{


    private $museumPostRepository;
    private $museumCategoryRepository;


    public function __construct()
    {
        parent::__construct();

        $this->museumPostRepository = app(MuseumPostRepository::class);
        $this->museumCategoryRepository = app(MuseumCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$postsList = MuseumPost::all();
        $postsList = $this->museumPostRepository->getAllWithPaginate();

        return view('museum.admin.post.index', compact('postsList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $item = $this->museumPostRepository->getEdit($id);
        $categoryList = $this->museumCategoryRepository->getForComboBox();


        return view('museum.admin.post.edit', compact('item', 'categoryList'));
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

        $item = $this->museumPostRepository->getEdit($id);
        $data = $request->all();


        if (empty($item)) {
            return back(['msg' => 'Сохраняемая категория не существует'])->withInput();
        }

       ;
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $result = $item
            ->fill($data)
            ->save();


        if ($result) {

            return response(['message' => 'Успешно сохранено', 'status' => 'OK', 'is_published' => $data['is_published']]);
//            return redirect()->route('museum.admin.posts.edit', $item->id)
//                ->with(['success' => 'Успешно сохранено']);
        } else {

            return response(['message' => 'Ошибка сохранения, перепроверьте данные', 'status' => 'ERROR']);

//            return back()->withErrors(['msg' => 'Ошибка сохранения'])
//                ->withInput();
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
        return response(['message' => 'Успешно удалено', 'status' => 'OK']);
        //dd($id);
    }
}
