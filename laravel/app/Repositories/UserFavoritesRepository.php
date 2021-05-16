<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 15.05.2021
 * Time: 22:57
 */

namespace App\Repositories;

use App\Models\MuseumPost;
use App\Models\UserFavorites as Model;
use Illuminate\Support\Facades\DB;


class UserFavoritesRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    public function getUserFavorites($userId)
    {

        $columns = [
            'user_id',
            'post_id',
            'created_at'
        ];

        $favorites = $this->startConditions()
            ->select($columns)
            ->where('user_id', '=', $userId)
            ->orderBy('id', 'desc')
            ->paginate(3)
            ->toArray();

        $hasNext = $favorites['current_page'] == $favorites['last_page'] ? false : true;

        return $favorites ? ['posts' => $this->getPosts($favorites['data']), 'hasNext' => $hasNext] : null;
    }

    private function getPosts($favorites)
    {
        foreach ($favorites as $item) {
            $postIds [] = [
                'post_id' => $item['post_id']
            ];
        }

        $posts = [];

        foreach ($postIds as $id) {
            $posts [] = MuseumPost::select(['id', 'russian_name', 'updated_at', 'collectors'])->where('id', '=', $id)->get()->toArray();
        }

        return array_merge(...$posts);
    }



}