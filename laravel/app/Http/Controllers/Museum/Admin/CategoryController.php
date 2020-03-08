<?php

namespace App\Http\Controllers\Museum\Admin;

use App\Http\Controllers\Controller;
use App\Models\MuseumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CategoryController extends BaseAdminController
{
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
      // dd($item);

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
        //
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

    public function getAllCategories() {

        $resp = MuseumCategory::all();

        return response()->json(['data' => $resp->toArray()]);

    }

    public function showAll() {

        $categoryList = MuseumCategory::all();

        return view('museum.admin.category.index', compact('categoryList'));
    }
}
