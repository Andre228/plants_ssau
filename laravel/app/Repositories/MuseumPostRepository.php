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

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    public function getForComboBox()
    {

        $columns = implode(', ' ,[
            'id',
            'CONCAT (id, ". ", title) AS id_title'
        ]);

        $result = $this
            ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();


        return $result;
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
            'category_id',

            'barcode',
            'adopted_name',
            'russian_name',
            'label_text',
            'accuracy',
            'collectors',
            'determination',
            'environmental_status',
            'label_name',
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