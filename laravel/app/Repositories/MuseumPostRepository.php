<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 17.03.2020
 * Time: 22:17
 */

namespace App\Repositories;

use App\Models\MuseumImage;
use App\Models\MuseumPost as Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;


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

        if ($howMuch !== null) {
            $result = $this->startConditions()
                ->select($this->getLotOfColumns())
                ->orderBy('id','DESC')
                ->with([
                    'category:id,title' ,
                    'user:id,name'
                ])
                ->paginate($howMuch);
        }

        else {
            $result = $this->startConditions()
                ->select($this->getLotOfColumns())
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
            $result = $this->startConditions()->whereIn('id', $ids)->forceDelete();
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
        $orderState = 'desc';

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

        if ($old) {
            $orderState = 'asc';
        }

        if ($new) {
            $orderState = 'desc';
        }

        $posts = $this->startConditions()
            ->select($columns)
            ->where('category_id', '=', $categoryId)
            ->where('is_published', '=', 1)
            ->orderBy('published_at', $orderState)
            ->get()
            ->toBase();


        return $posts;

    }

    public function search($params)
    {

//        $result = $this->startConditions()::select($this->getLotOfColumns())
//            ->where('is_published', '=', 1)
//            ->where('barcode', $params['barcode']['match'], $params['barcode']['value'])
//            ->where('determination', $params['determination']['match'], $params['determination']['value'])
//            ->where('russian_name', $params['russian_name']['match'], $params['russian_name']['value'])
//            ->where('collection_date', $params['collection_date']['match'], $params['collection_date']['value']);


        $query = $this->startConditions()::select($this->getLotOfColumns())
            ->with(['category:id,title'])
            ->where('is_published', '=', 1);

        foreach ($params[0] as $key => $value) {
            if ($value->match != 'any') {
                $query->where("{$key}", "{$value->match}", "{$value->value}");
            }
        }

        $posts = $query->get()->toArray();
        $result = [];

        for($i = 0; $i < count($posts); $i++) {
            $image = MuseumImage::where('post_id', '=', $posts[$i]['id'])->get()->toArray();
            $result[$i] = Arr::add($posts[$i], 'image', $image);
            $result[$i]['collection_date'] = Carbon::parse($result[$i]['collection_date'])->format('Y-m-d');
        }

        return $result;
    }

    private function getLotOfColumns()
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
            'collection_date',
            'coordinates'
        ];

        return $columns;

    }

}