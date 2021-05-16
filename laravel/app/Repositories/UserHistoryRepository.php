<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 16.05.2021
 * Time: 11:50
 */

namespace App\Repositories;


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

        $data [] = [
            'user_id' => $userId,
            'post_id' => $postId
        ];

        $item = new Model($data);
        $item->user_id = $userId;
        $item->post_id = $postId;
        $result = $item->save();

        return $result;

    }

}