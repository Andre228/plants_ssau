<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 17.03.2020
 * Time: 22:17
 */

namespace App\Repositories;

use App\Models\MuseumPost as Model;


class MuseumPostRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }


    public function getAllWithPaginate($howMuch = null)
    {
        $columns = [
            'id',
            'title',
            'slug',
            'author',
            'is_published',
            'published_at',
            'user_id',
            'category_id'
        ];

        if ($howMuch !== null) {
            $result = $this->startConditions()
                ->select($columns)
                ->orderBy('id','DESC')
                ->with([
                    'category:id,title' ,
                    'user:id,name'
                ])
                ->paginate($howMuch);
        }

        else {
            $result = $this->startConditions()
                ->select($columns)
                ->orderBy('id','DESC')
                ->with([
                    'category:id,title' ,
                    'user:id,name'
                ])
                ->get();
        }

        return $result;
    }

}