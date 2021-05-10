<?php

namespace App\Http\Controllers\Museum;

use App\Http\Controllers\Controller;
use App\Models\MuseumPost;
use App\Repositories\MuseumImageRepository;
use App\Repositories\MuseumPostRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Museum\BaseController as BaseController;
use Illuminate\Support\Carbon;

class PostController extends BaseController
{

    private $museumPostRepository;
    private $museumImageRepository;


    public function __construct()
    {
        parent::__construct();

        $this->museumPostRepository = app(MuseumPostRepository::class);
        $this->museumImageRepository = app(MuseumImageRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $barcode, $determination, $russian_name, $collection_date, $label_text, $accuracy, $adopted_name, $environmental_status)
    {
        $foundPosts = null;
        $params [] = [
            'barcode' => json_decode(urldecode($barcode)),
            'determination' => json_decode(urldecode($determination)),
            'russian_name' => json_decode(urldecode($russian_name)),
            'collection_date' => json_decode(urldecode($collection_date)),
            'label_text' => json_decode(urldecode($label_text)),
            'accuracy' => json_decode(urldecode($accuracy)),
            'adopted_name' => json_decode(urldecode($adopted_name)),
            'environmental_status' => json_decode(urldecode($environmental_status))
        ];

        if (!empty($params)) {
            $foundPosts = $this->museumPostRepository->search($params);
            if (!empty($foundPosts)) {
                $foundPosts = $foundPosts;
            } else {
                $foundPosts = [];
            }
        }

        $listPosts = $foundPosts ? json_encode($foundPosts) : [];


        return view('museum.posts.index', compact('listPosts'));
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
        $item = $this->museumPostRepository->getEdit($id);
        $images = null;
        if (!empty($item)) {
            $item->collection_date = Carbon::parse($item->collection_date)->format('Y-m-d');
            $images = $this->museumImageRepository->getAllImagesByPostId($id);
        }

        return view('museum.posts.show', compact('item', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
}
