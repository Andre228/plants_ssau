<?php

namespace App\Http\Controllers\Museum\Admin;

use App\Imports\PostsImport;
use App\Models\MuseumPost;
use App\Repositories\MuseumCategoryRepository;
use App\Repositories\MuseumImageRepository;
use App\Repositories\MuseumPostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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
        $postsList = $this->museumPostRepository->getAllWithPaginate(50);

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
        $item['collection_date'] = Carbon::parse($item['collection_date'])->format('Y-m-d');
        $categoryList = $this->museumCategoryRepository->getForComboBox();
        $imageList = $this->museumImageRepository->getAllImagesByPostId($id);

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

        $this->museumImageRepository->deleteAllImagesByPost($id);
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
        try {
            foreach ($data as $key => $value) {
                if ($key != 'updated_at' && $request->hasFile('file0')) {
                    $this->museumImageRepository->createImage($request, $value, $id);
                }
            }
            $post = $this->museumPostRepository->getEdit($id);
            if(!empty($post)) {
                $post->updated_at = $data['updated_at'];
                $post->save();
            }
            $images = $this->museumImageRepository->getAllImagesByPostId($id);
            return response(['message' => 'Успешно загружено', 'status' => 'OK', 'details' => $images]);
        } catch (Exception $exception) {
            return response(['message' => 'Ошибка загрузки файла', 'status' => 'ERROR']);
        }

    }

    public function change(Request $request, $id)
    {
        $data = $request->all();
        if (!empty($data)) {
            $imageResource = $this->museumImageRepository->getImageByPostIdAndId($id, $data['imageId']);
            if (!empty($imageResource)) {
                $isDeleted = $this->museumImageRepository->deleteImageFromFilesystem($imageResource[0]->alias);
                if ($isDeleted) {
                    $result = $this->museumImageRepository->updateImage($request, $data['file'], $id, $imageResource[0]);
                    $post = $this->museumPostRepository->getEdit($id);
                    if(!empty($post)) {
                        $post->updated_at = $data['updated_at'];
                        $post->save();
                    }
                    if ($result) {
                        $image = $this->museumImageRepository->getEdit($data['imageId']);
                        return response(['message' => 'Успешно изменено', 'status' => 'OK', 'details' => $image]);
                    } else {
                        return response(['message' => 'Изображение не изменено', 'status' => 'ERROR']);
                    }
                }
            }
        }

    }

    public function deleteImage(Request $request, $id)
    {
        $data = $request->all();

        if (!empty($data['imageId']) && !empty($data['alias'])) {
            $image = $this->museumImageRepository->getEdit($data['imageId']);
            if (!empty($image)) {
                $isDeleted = $this->museumImageRepository->deleteImageFromFilesystem($data['alias']);
                if ($isDeleted) {
                    $result = $image->forceDelete();
                    $post = $this->museumPostRepository->getEdit($id);
                    if(!empty($post)) {
                        $post->updated_at = $data['updated_at'];
                        $post->save();
                    }
                    if ($result) {
                        return response(['message' => 'Успешно удалено', 'status' => 'OK']);
                    } else {
                        return response(['message' => 'Ошибка удаления', 'status' => 'ERROR']);
                    }
                }
            } else {
                return response(['message' => 'Изображение не найдено', 'status' => 'ERROR']);
            }

        } else {
            return response(['message' => 'Нельзя удалить изображение', 'status' => 'ERROR']);
        }

    }

    public function import(Request $request)
    {
        $prevCount = $this->museumPostRepository->getAllWithPaginate()->count();

        if ($request->hasFile('file')) {

            Excel::import(new PostsImport, $request->file('file'));

            $currentCount = $this->museumPostRepository->getAllWithPaginate()->count();
            $count = $currentCount - $prevCount;

            if ($prevCount < $currentCount) {
                return response(['message' => "Успешно импортировано <strong> $count </strong> новых записей", 'status' => 'OK']);
            } else {
                return response(['message' => 'Ошибка импорта', 'status' => 'ERROR']);
            }

        } else {
            return response(['message' => 'Вы не передали файл', 'status' => 'ERROR']);
        }
    }

    public function deletePosts($count)
    {
        if ($count > 0) {

            $lastPosts = $this->museumPostRepository->getLastPosts($count);

            $postIds = [];

            foreach ($lastPosts as $post) {
                $postIds [] = [
                    'id' => $post['id']
                ];
            }

            $isDeletedImages = $this->museumImageRepository->deleteMoreImagesFromFileSystem($postIds);
            if ($isDeletedImages) {
                $result = $this->museumPostRepository->deleteMore($count, $lastPosts);

                if ($result > 0) {
                    return response(['message' => "Успешно удалены <strong> $count </strong> записей", 'status' => 'OK']);
                } else {
                    return response(['message' => 'Ошибка удаления', 'status' => 'ERROR']);
                }
            } else {
                return response(['message' => 'Ошибка удаления', 'status' => 'ERROR']);
            }

        } else {
            return response(['message' => 'Ошибка удаления', 'status' => 'ERROR']);
        }
    }

    public function fetchMorePosts()
    {
        $posts = $this->museumPostRepository->getAllWithPaginate(50);

        if (!empty($posts)) {
            return response(['status' => 'OK', 'details' => $posts]);
        } else {
            return response(['message' => 'Ошибка', 'status' => 'ERROR']);
        }
    }

    public function search(Request $request)
    {
        $posts = $this->museumPostRepository->searchForAdmin($request->params);

        if (count($posts) > 0) {
            return response(['status' => 'OK', 'details' => $posts]);
        } else {
            return response(['message' => 'Поиск не дал результатов', 'status' => 'OK']);
        }
    }
}
