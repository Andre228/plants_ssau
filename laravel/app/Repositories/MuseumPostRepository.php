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

    public function deleteMore($count, $posts = null)
    {
        if ($posts == null) {
            $posts = $this->getLastPosts($count);
        }


        $ids [] = [];
        $result = null;

        for ($i = 0; $i < count($posts); $i++ ) {
            $ids[$i] = $posts[$i]['id'];
        }

        if (!empty($ids)) {
            $result = $this->startConditions()->whereIn('id', $ids)->delete();
        }

        return $result;
    }

    public function getLastPosts($count)
    {
        $posts = $this->startConditions()->orderBy('id', 'desc')->take($count)->get()->toArray();

        return $posts;
    }

    public function getLastPublishedPosts($count = 10)
    {

        $columns = [
            'id',
            'title',
            'author',
            'is_published',
            'published_at',
            'russian_name',
            'determination',
            'collectors',
            'collection_date'
        ];

        $posts = $this->startConditions()
            ->select($columns)
            ->where('is_published', '=', 1)
            ->orderBy('id', 'desc')
            ->take($count)
            ->get()
            ->toBase();

        return $posts;
    }

    public function getPostsByCategoryId($categoryId, $new = true, $old = false)
    {
        $posts = null;

        $columns = [
            'id',
            'title',
            'author',
            'is_published',
            'published_at',
            'russian_name',
            'determination',
            'collectors',
            'collection_date'
        ];

        if ($new) {
            $posts = $this->startConditions()
                ->select($columns)
                ->where('category_id', '=', $categoryId)
                ->where('is_published', '=', 1)
                ->orderBy('published_at', 'desc')
                ->get()
                ->toBase();
        }

        if ($old) {
            $posts = $this->startConditions()
                ->select($columns)
                ->where('category_id', '=', $categoryId)
                ->where('is_published', '=', 1)
                ->orderBy('published_at', 'asc')
                ->get()
                ->toBase();
        }



        return $posts;

    }

}