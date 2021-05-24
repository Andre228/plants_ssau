<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 21.06.2020
 * Time: 18:48
 */

namespace App\Repositories;

use App\Models\User as Model;
use App\Models\UserReadingNews;


class MuseumUserRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    public function getUser($id)
    {
        $columns = [
            'id',
            'name',
            'role',
            'email',
            'likes'
        ];

        $result = $this
            ->startConditions()
            ->select($columns)
            ->where('id', '=', $id)
            ->get()
            ->toArray();

        return array_merge(...$result);
    }

    public function getUserBaseInfo($id)
    {
        $columns = [
            'id',
            'name',
            'role'
        ];

        $result = $this
            ->startConditions()
            ->select($columns)
            ->where('id', '=', $id)
            ->with([
                'user_favorites:id,user_id,post_id',
                'user_reading:id,user_id,news_id'
            ])
            ->get()
            ->toArray();

        return $result;
    }

    public function isReadingNews($newsId, $userId)
    {
        $result = UserReadingNews::select(['id', 'news_id', 'user_id'])
            ->where('news_id', '=', $newsId)
            ->where('user_id', '=', $userId)
            ->first();

        return $result;
    }

    public function getAllUsers()
    {
        $columns = [
            'id',
            'name',
            'email',
            'role',
            'created_at'
        ];

        $result = $this
            ->startConditions()
            ->select($columns)
            ->toBase()
            ->get();

        return $result;
    }

    public function getAllWithPaginate($howMuch = null)
    {
        $columns = [
            'id',
            'name',
            'email',
            'role',
            'created_at'
        ];

        if ($howMuch !== null) {
            $result = $this->startConditions()
                ->select($columns)
                ->paginate($howMuch);
        }

        else {
            $result = $this->startConditions()
                ->select($columns)
                ->get();
        }


        return $result;
    }

}