<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 15.11.2020
 * Time: 19:51
 */

namespace App\Repositories;

use App\Models\MuseumImage as Model;


class MuseumImageRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    public function getAllImagesByPostId($postId)
    {
        $columns = [
            'id',
            'post_id',
            'alias'
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->where('post_id', $postId)
            ->toBase()
            ->get();

        return $result;

    }

}