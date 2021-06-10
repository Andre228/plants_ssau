<?php

namespace App\Http\Controllers\Museum;

use App\Repositories\MuseumImageRepository;
use App\Repositories\MuseumPostRepository;
use App\Repositories\MuseumUserRepository;
use App\Repositories\UserHistoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Museum\BaseController as BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PostController extends BaseController
{

    private $museumPostRepository;
    private $museumImageRepository;
    private $museumUserRepository;
    private $userHistoryRepository;


    public function __construct()
    {
        parent::__construct();

        $this->museumPostRepository = app(MuseumPostRepository::class);
        $this->museumImageRepository = app(MuseumImageRepository::class);
        $this->museumUserRepository = app(MuseumUserRepository::class);
        $this->userHistoryRepository = app(UserHistoryRepository::class);
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
                $foundPosts = [
                    'posts' => null
                ];
            }
        }

        $listPosts = $foundPosts ? json_encode($foundPosts) : [];


        return view('museum.posts.index', compact('listPosts'));
    }

    public function viewPosts()
    {
        $popularPosts = $this->museumPostRepository->getPopularPost();
        $postsList = $this->museumPostRepository->getPostsWithPagination();

        return view('museum.posts.posts', compact('popularPosts', 'postsList'));
    }

    public function fetchPosts()
    {
        $posts = $this->museumPostRepository->getPostsWithPagination();

        if ($posts) {
            return response(['status' => 'OK', 'details' => $posts]);
        } else {
            return response(['status' => 'ERROR']);
        }
    }

    public function fetchPostsForPeriod($period)
    {
        $posts = $this->museumPostRepository->getPostsOfPeriod($period);

        if ($posts) {
            return response(['status' => 'OK', 'details' => $posts]);
        } else {
            return response(['status' => 'ERROR']);
        }
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
        $item = $this->museumPostRepository->getPublishedPost($id)->toBase()[0];
        $images = null;
        $userInfo = Auth::user();
        if (empty($userInfo)) {
            $userInfo = json_encode((object) [
                'user' => 'null',
                'status' => 401
            ]);
        } else {
            $userInfo = json_encode($this->museumUserRepository->getUserBaseInfo($userInfo->id)[0]);
        }

        if (!empty($item)) {
            $item->collection_date = Carbon::parse($item->collection_date)->format('Y-m-d');
            $images = $this->museumImageRepository->getAllImagesByPostId($id);
        } else {
            return redirect()->back();
        }

        return view('museum.posts.show')->with(['item' => $item])->with(['images' => $images])->with(['userInfo' => $userInfo]);
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

    public function incrementCountViews($id)
    {
        $result = $this->museumPostRepository->setCountViews($id);
        if ($result) {
            return response(['status' => 'OK']);
        } else {
            return response(['status' => 'ERROR']);
        }

    }

    public function updateHistory($userId, $postId)
    {

        $result = $this->userHistoryRepository->updateHistory($userId, $postId);

        if ($result) {
            return response(['status' => 'OK']);
        } else {
            return response(['status' => 'ERROR']);
        }

    }
}
