<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 23.05.2021
 * Time: 12:17
 */

namespace App\Http\Controllers\Museum;

use App\Http\Controllers\Controller;
use App\Models\MuseumNewsInfo;
use App\Models\User;
use App\Repositories\MuseumNewsRepository;
use App\Repositories\MuseumUserRepository;
use App\Repositories\UserReadingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends BaseController
{

    private $museumNewsRepository;
    private $museumUserRepository;

    public function __construct()
    {
        parent::__construct();

        $this->museumNewsRepository = app(MuseumNewsRepository::class);
        $this->museumUserRepository = app(MuseumUserRepository::class);
    }


    public function show($id)
    {
        $userId = Auth::id();
        $newsInfo = $this->museumNewsRepository->getNewsWithAllInfo($id);
        $readingNews = $this->museumUserRepository->isReadingNews($id, $userId);
        $like = in_array($id, $this->museumUserRepository->getEdit($userId)->likes);

        if ($like) {
            $like = "true";
        } else {
            $like = "false";
        }

        if (!$readingNews) {
            $readingNews = "false";
        }

        return view('museum.news.show', compact('newsInfo', 'readingNews', 'like'));
    }

    public function addComment(Request $request, $newsId, $newsInfoId, $replyId = null)
    {

        $data = $request->all();

        $replyComments = null;


        if (empty($replyId)) {
            $replyComments = $this->museumNewsRepository->createNewComment($data, $newsId, $newsInfoId, null, Auth::id(), Auth::user()->name);
        } else {
            $replyComments = $this->museumNewsRepository->createNewComment($data, $newsId, $newsInfoId, $replyId, Auth::id(), Auth::user()->name);
        }

        if (!empty($replyComments)) {
            return response(['status' => 'OK', 'message' => 'Сохранено', 'details' => $replyComments]);
        } else {
            return response([ 'status' => 'ERROR', 'message' => 'Произошла ошибка']);
        }
    }

    public function likeNews($id)
    {
        $userId = Auth::id();
        $user = $this->museumUserRepository->getUser($userId);
        $likes = $user['likes'];
        $isLike = false;
        $message = 'Удалено из понравившихся';

        $newsInfo = MuseumNewsInfo::where('news_id', $id)->get()->toArray()[0];


        if (in_array($id, $likes)) {
            $key = array_search($id, $likes);
            $newsInfo['likes'] = $newsInfo['likes'] - 1;
            array_splice($likes, $key, 1);
        } else {
            $isLike = true;
            $message = 'Добавлено в понравившиеся';
            array_push($likes, +$id);
            $newsInfo['likes'] = $newsInfo['likes'] + 1;
        }



        $user['likes'] = $likes;
        $result = User::where('id', $userId)->update($user);
        $updatedInfo = MuseumNewsInfo::where('id', $newsInfo['id'])->update($newsInfo);


        if ($result) {
            return response(['status' => 'OK', 'message' => $message, 'like' => $isLike, 'likeCount' => $newsInfo['likes']]);
        } else {
            return response([ 'status' => 'ERROR', 'message' => 'Произошла ошибка']);
        }
    }

}