<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 25.04.2021
 * Time: 17:55
 */

namespace App\Repositories;

use App\Models\MuseumNews as Model;
use App\Models\MuseumNewsComment;
use App\Models\User;


class MuseumNewsRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    public function getNewsWithAllInfo($id)
    {
        $columns = [
            'id',
            'user_id',
            'title',
            'content_raw',
            'content_html',
            'is_published',
            'updated_at'
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->where('id', '=', $id)
            ->with(['news_info:news_id,likes'])
            ->with(['news_info.news_comments'])
            ->with(['news_info.news_comments.reply'])
            ->get()
            ->toArray();

        $user = User::select(['id', 'name'])->where('id', '=', $result[0]['user_id'])->first()->toArray();
        $result [0]['user'] = $user;

        return json_encode($result[0]);


    }

    public function getAllWithPaginate($howMuch = null)
    {
        $columns = [
            'id',
            'user_id',
            'title',
            'content_raw',
            'content_html',
            'is_published',
            'updated_at'
        ];

        if ($howMuch !== null) {
            $result = $this->startConditions()
                ->select($columns)
                ->orderBy('id','DESC')
                ->with([
                    'user:id,name'
                ])
                ->paginate($howMuch);
        }

        else {
            $result = $this->startConditions()
                ->select($columns)
                ->orderBy('id','DESC')
                ->with([
                    'user:id,name'
                ])
                ->get();
        }

        return $result;
    }


    public function getLastNews()
    {
        $columns = [
            'id',
            'title',
            'user_id',
            'content_raw',
            'updated_at',
            'is_published'
        ];

        $news = $this->startConditions()
            ->select($columns)
            ->where('is_published', '=', 1)
            ->orderBy('id','DESC')
            ->with([
                'user:id,name'
            ])
            ->paginate(5)
            ->toArray();

        $hasNext = $news['current_page'] == $news['last_page'] ? false : true;


        return json_encode([ 'news' => $news['data'], 'hasNext' => $hasNext ]);
    }

    public function createNewComment($data, $newsId, $newsInfoId, $replyId, $userId, $username)
    {

        $data ['news_id'] = $newsId;
        $data ['news_info_id'] = $newsInfoId;
        if ($replyId) {
            $data ['reply_id'] = $replyId;
        }
        $data ['user_id'] = $userId;
        $data ['username'] = $username;

        $item = new MuseumNewsComment($data);
        $result = $item->save();

        if ($result) {
            $newsInfo = $this->getNewsWithAllInfo($newsId);
            return $newsInfo;
        } else {
            return false;
        }

    }

}