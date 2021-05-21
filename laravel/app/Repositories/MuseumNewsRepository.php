<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 25.04.2021
 * Time: 17:55
 */

namespace App\Repositories;

use App\Models\MuseumNews as Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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

}