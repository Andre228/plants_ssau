<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 22.05.2021
 * Time: 0:03
 */

namespace App\Repositories;

use App\Models\MuseumNews;
use App\Models\UserReadingNews as Model;


class UserReadingRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    public function getUserReadingNews($userId, $all = false)
    {

        $columns = [
            'user_id',
            'news_id',
            'created_at'
        ];

        if ($all) {

            $favorites = $this->startConditions()
                ->select($columns)
                ->where('user_id', '=', $userId)
                ->orderBy('id', 'desc')
                ->get()
                ->toArray();

        } else {

            $favorites = $this->startConditions()
                ->select($columns)
                ->where('user_id', '=', $userId)
                ->orderBy('id', 'desc')
                ->paginate(3)
                ->toArray();

            $hasNext = $favorites['current_page'] == $favorites['last_page'] ? false : true;
        }


        return $all ? $this->getNews($favorites) : ['posts' => $this->getNews($favorites['data']), 'hasNext' => $hasNext];
    }

    private function getNews($favorites)
    {
        $newsIds = [];
        foreach ($favorites as $item) {
            $newsIds [] = [
                'news_id' => $item['news_id']
            ];
        }

        $news = [];

        foreach ($newsIds as $id) {
            $news [] = MuseumNews::select(['id', 'user_id', 'title'])->where('id', '=', $id)->get()->toArray();
        }

        return array_merge(...$news);
    }

//    public function getUserFavoritesNews($userId)
//    {
//        $columns = [
//            'news_id'
//        ];
//
//        $favorites = $this->startConditions()
//            ->select($columns)
//            ->where('user_id', '=', $userId)
//            ->orderBy('id', 'desc')
//            ->get()
//            ->toArray();
//
//        return json_encode($favorites);
//    }

}