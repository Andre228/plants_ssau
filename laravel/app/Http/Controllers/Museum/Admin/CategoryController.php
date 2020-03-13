<?php

namespace App\Http\Controllers\Museum\Admin;

use App\Http\Controllers\Controller;
use App\Models\MuseumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Str;

class CategoryController extends BaseAdminController
{


//    protected $headers = Request::HEADER_X_FORWARDED_ALL;


    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($how)
    {

        if($how == 'per-page') {

            $categoryList = MuseumCategory::paginate(5);

            return view('museum.admin.category.index', compact('categoryList'));
        }

        if($how == 'all') {

            $categoryList = MuseumCategory::all();

            return view('museum.admin.category.index', compact('categoryList'));
        }
        //$paginator = DB::table('museum_categories')->simplePaginate(15);



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $item = new MuseumCategory();
        $categoryList = MuseumCategory::all();

        return view('museum.admin.category.create', compact('item','categoryList'));

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
    public function edit($id)
    {
       $item =  MuseumCategory::find($id);
       $categoryList = MuseumCategory::all();

       if(empty($item)) {
          return back(['msg' => 'Запись не найдена']);
       }

        if (empty($categoryList)) {
            return back(['msg' => 'В списке нет ни одной категории']);
        }

        return view('museum.admin.category.edit', compact('item', 'categoryList'));
       // return 'edit' . $id;
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

        $result = MuseumCategory::destroy($id);

        if ($result > 0) {
            return redirect()->route('museum.admin.categories.index', 'all')
                ->with(['success' => 'Запись успешно удалена']);
        } else {
            return back()->withErrors(['msg' => 'Ошибка удаления'])
                ->withInput();
        }

    }

    public function getAllCategories() {

        $resp = MuseumCategory::all();

        return response()->json(['data' => $resp->toArray()]);

    }

    public function showAll($how) {

//        if($how == 'per-page') {
//
//            $categoryList = MuseumCategory::paginate(5);
//
//            return view('museum.admin.category.index', compact('categoryList'));
//        }
//
//        if($how == 'all') {
//
//            $categoryList = MuseumCategory::all();
//
//            return view('museum.admin.category.index', compact('categoryList'));
//        }
    }
}
