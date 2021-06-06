<?php

namespace App\Http\Controllers\Museum\Admin;

use App\Http\Controllers\Controller;
use App\Models\MuseumCategory;
use App\Repositories\MuseumCategoryRepository;
use App\Repositories\MuseumImageRepository;
use App\Repositories\MuseumPostRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Str;

class CategoryController extends BaseAdminController
{


//    protected $headers = Request::HEADER_X_FORWARDED_ALL;

    private $museumCategoryRepository;
    private $museumPostRepository;
    private $museumImageRepository;


    public function __construct()
    {
        parent::__construct();
        $this->museumCategoryRepository = app(MuseumCategoryRepository::class);
        $this->museumPostRepository = app(MuseumPostRepository::class);
        $this->museumImageRepository = app(MuseumImageRepository::class);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($how)
    {
        $categoryList = $this->museumCategoryRepository->getCategories($how);

        return view('museum.admin.category.index', compact('categoryList'));

    }

    public function indexTree()
    {
        $categoryList = $this->museumCategoryRepository->getCategoriesTree();
        $categoryList = json_encode($categoryList);

        return view('museum.admin.category.tree', compact('categoryList'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $item = new MuseumCategory();
        $categoryList = $this->museumCategoryRepository->getForComboBox();

        return view('museum.admin.category.create', compact('categoryList', 'item'));

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

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $item = new MuseumCategory($data);
        $item->save();

        if ($item) {
            return redirect()->route('museum.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
          return back()->withErrors(['msg' => 'Ошибка сохранения'])
              ->withInput();
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
       // dd(__METHOD__);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, MuseumCategoryRepository $museumCategoryRepository)
    {
       $item = $museumCategoryRepository->getEdit($id);
       $categoryList = $museumCategoryRepository->getForComboBox();

       $countPosts = count($this->museumPostRepository->getPostsIdsByCategoryIdAll($item->id));

       if(empty($item)) {
          return back(['msg' => 'Запись не найдена']);
       }

        if (empty($categoryList)) {
            return back(['msg' => 'В списке нет ни одной категории']);
        }

        return view('museum.admin.category.edit', compact('item', 'categoryList', 'countPosts'));

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

        $item = MuseumCategory::find($id);

        if (empty($item)) {
            return back(['msg' => 'Сохраняемая категория не существует'])->withInput();
        }

        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $result = $item
                  ->fill($data)
                  ->save();

        if ($result) {
            return redirect()->route('museum.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
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
        $childrenIds = [];
        $childrenOfCategory = $this->museumCategoryRepository->getChildrenCategories($id);

        if (!empty($childrenOfCategory)) {
            foreach ($childrenOfCategory as $item) {
                array_push($childrenIds, $item->id);
            }
        }

        array_push($childrenIds, $id);
        $childrenIds = array_map('strval', $childrenIds);

        $postIds = $this->museumPostRepository->getPostIdsByCategories($childrenIds);
        $isDeletedImages = $this->museumImageRepository->deleteMoreImagesFromFileSystem($postIds);
        $result = $this->museumCategoryRepository->deleteListCategories($childrenIds);


        if ($result && $isDeletedImages) {
            return redirect()->route('museum.admin.categories.index', 'all')
                ->with(['success' => 'Категория успешно удалена']);
        } else {
            return back()->withErrors(['msg' => 'Ошибка удаления'])
                ->withInput();
        }

    }

    public function getAllCategories() {

        $resp = MuseumCategory::all();

        return response()->json(['data' => $resp->toArray()]);

    }

    public function search(Request $request)
    {
        $search = $request->search;
        $categoryList = $this->museumCategoryRepository->getSearchingCategories($request->search);

        return view('museum.admin.category.index', compact('categoryList', 'search'));
    }

}
