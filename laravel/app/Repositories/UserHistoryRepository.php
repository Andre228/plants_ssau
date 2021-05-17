<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 16.05.2021
 * Time: 11:50
 */

namespace App\Repositories;


use App\Models\MuseumPost;
use App\Models\UserHistory as Model;

class UserHistoryRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    public function updateHistory($userId, $postId)
    {
        $result = null;



        $data [] = [
            'user_id' => $userId,
            'post_id' => $postId
        ];

        $item = new Model($data);
        $item->user_id = $userId;
        $item->post_id = $postId;
        $result = $item->save();

        $historiesList = $this->startConditions()
            ->where('user_id', '=', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();


        if (!empty($historiesList)) {
            for ($i = count($historiesList) - 1; $i > 2; $i--) {
                $history = $this->getEdit($historiesList[$i]['id']);
                if (!empty($history)) {
                    $history->delete();
                }
            }
        }


        return $result;

    }

    public function getHistories($userId)
    {
        $historiesList = $this->startConditions()
            ->where('user_id', '=', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        return $this->getPosts($historiesList);
    }

    private function getPosts($histories)
    {
        foreach ($histories as $item) {
            $postIds [] = [
                'post_id' => $item['post_id'],
                'seen_date' => $item['created_at']
            ];
        }

        $posts = [];

        foreach ($postIds as $id) {
            $post = MuseumPost::select(['id', 'russian_name', 'updated_at', 'collectors'])->where('id', '=', $id['post_id'])->get()->toArray();
            $posts [] = [
                'post' => array_merge(...$post),
                'seen_date' => $id['seen_date'],
            ];
        }

        return $posts;
    }

}