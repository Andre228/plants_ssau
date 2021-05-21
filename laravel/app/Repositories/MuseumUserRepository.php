<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 21.06.2020
 * Time: 18:48
 */

namespace App\Repositories;

use App\Models\User as Model;


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