<?php

namespace App\Http\Controllers\Museum\Admin;

use App\Imports\PostsImport;
use App\Models\MuseumImage;
use App\Models\MuseumPost;
use App\Repositories\MuseumCategoryRepository;
use App\Repositories\MuseumImageRepository;
use App\Repositories\MuseumPostRepository;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PostController extends BaseAdminController
{


    private $museumPostRepository;
    private $museumCategoryRepository;
    private $museumImageRepository;


    public function __construct()
    {
        parent::__construct();

        $this->museumPostRepository = app(MuseumPostRepository::class);
        $this->museumCategoryRepository = app(MuseumCategoryRepository::class);
        $this->museumImageRepository = app(MuseumImageRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $categoryList = $this->museumCategoryRepository->getForComboBox();
        $postInfo = new MuseumPost();

        return view('museum.admin.post.create', compact('categoryList', 'postInfo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->input();
        $data['user_id'] = Auth::id();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $item = new MuseumPost($data);

        $result = $item->save();


        if ($result) {
            return response(['message' => 'Запись успешно создана', 'status' => 'OK', 'id' => $item['id']]);
        } else {
            return response(['message' => 'Ошибка сохранения, перепроверьте данные', 'status' => 'ERROR']);
        }
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
        $imageList = $this->museumImageRepository->getAllImagesByPostId($id);
        //dd();

      // $arr = $imageList->toArray();


        return view('museum.admin.post.edit')->with('item', $item)->with('categoryList', $categoryList)->with('imageList', $imageList);
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
            return response(['message' => 'Сохраняемая категория не существует']);
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

        $post = $this->museumPostRepository->getEdit($id);
        $result = $post->forceDelete();


        if ($result) {
            return response(['message' => 'Успешно удалено', 'status' => 'OK']);
        } else {
            return response(['message' => 'Ошибка удаления', 'status' => 'ERROR']);
        }

    }

    public function upload(Request $request, $id)
    {
        $data = $request->all();
        if ($request->hasFile('file')) {

            $date = str_replace(' ', '_', $request->updated_at);
            $date = str_replace(':', '_', $date);

            $fileName = $date . '_' . rand(100, 1000000) . '_' . Str::random(10) . '_' . $data['file']->getClientOriginalName();
            $filePath = 'images/posts/' . $id;

            $path = Storage::disk('public')->putFileAs(
                $filePath,
                $request->file('file'),
                $fileName
            );

            $path = '/storage/' . $path;

            if ($path) {

                $data = array(
                    'post_id' => $id,
                    'name' => $fileName,
                    'alias' => $path,
                );

                $imgobject = new MuseumImage();
                $imgobject->create($data);

                return response(['message' => 'Успешно загружено', 'status' => 'OK']);
            } else {
                return response(['message' => 'Ошибка загрузки файла', 'status' => 'ERROR']);
            }

        }

    }

    public function import(Request $request)
    {
        $prevCount = $this->museumPostRepository->getAllWithPaginate()->count();

        if ($request->hasFile('file')) {

            Excel::import(new PostsImport, $request->file('file'));

            $currentCount = $this->museumPostRepository->getAllWithPaginate()->count();

            if ($prevCount < $currentCount) {
                return response(['message' => 'Успешно импортировано', 'status' => 'OK']);
            } else {
                return response(['message' => 'Ошибка импорта', 'status' => 'ERROR']);
            }

        } else {
            return response(['message' => 'Вы не передали файл', 'status' => 'ERROR']);
        }
    }
}
