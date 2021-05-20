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
use phpDocumentor\Reflection\Types\This;


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

    public function setCountViews($postId)
    {
        $post = $this->getEdit($postId);
        $result = null;
        if (!empty($post)) {
            $post->count_views = $post->count_views + 1;
            $result = $post->save();
        } else {
            $result = false;
        }

        return $result;
    }

    public function getPopularPost()
    {
        $result = $this->startConditions()::select(['id', 'russian_name', 'count_views', 'published_at'])
            ->with(['category:id,title'])
            ->where('is_published', '=', 1)
            ->orderBy('count_views', 'desc')
            ->take(3)
            ->get();

        return $result;
    }

    public function getPostsWithPagination()
    {

        $result [] = [];

        $postsPaginated = $this->startConditions()::select($this->getLotOfColumns())
            ->where('is_published', '=', 1)
            ->orderBy('id', 'desc')
            ->paginate(50)
            ->toArray();

        $hasNext = $postsPaginated['current_page'] == $postsPaginated['last_page'] ? false : true;

        $posts = $postsPaginated['data'];

        $result = $this->setImagesForPosts($posts);

        return json_encode([ 'posts' => $result, 'hasNext' => $hasNext]);
    }

    public function getPostsOfPeriod($period)
    {

        $date = null;

        if ($period == 'week') {
            $date = Carbon::today()->subDays(7);
        }

        if ($period == 'month') {
            $date = Carbon::now()->subDays(30)->toDateTimeString();
        }

        $posts = $this->startConditions()::select($this->getBaseColumns())
            ->where('created_at', '>=', $date)
            ->where('is_published', '=', 1)
            ->orderBy('id', 'desc')
            ->with([
                'category:id,title' ,
                'user:id,name'
            ])
            ->get()
            ->toArray();


        return !empty($this->setImagesForPosts($posts)[0]) ? $this->setImagesForPosts($posts) : [];
    }

    private function setImagesForPosts($posts)
    {
        $result [] = [];

        for($i = 0; $i < count($posts); $i++) {
            $image = MuseumImage::where('post_id', '=', $posts[$i]['id'])->get()->toArray();
            $result[$i] = Arr::add($posts[$i], 'images', $image);
            $result[$i]['collection_date'] = Carbon::parse($result[$i]['collection_date'])->format('Y-m-d');
        }

        return $result;
    }

    private function getBaseColumns()
    {
        $columns = [
            'id',
            'is_published',
            'published_at',
            'created_at',
            'user_id',
            'category_id',

            'barcode',
            'adopted_name',
            'russian_name',
            'label_text',
            'collectors',
            'determination',
            'label_name',
            'collection_date',
            'count_views'
        ];

        return $columns;
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
            'coordinates',
            'count_views'
        ];

        return $columns;

    }

}