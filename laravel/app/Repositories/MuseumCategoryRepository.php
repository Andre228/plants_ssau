<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 17.03.2020
 * Time: 21:05
 */

namespace App\Repositories;

use App\Models\MuseumCategory as Model;
use Illuminate\Support\Facades\DB;

class MuseumCategoryRepository extends CoreRepository
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

    public function getCategories($how)
    {
        $columns = ['id', 'title', 'parent_id'];
        $categoryList = null;

        if($how == 'per-page') {
            $categoryList = Model::paginate(5);
        }

        if($how == 'all') {
            $categoryList = Model::all();
        }

        return $categoryList;

    }

    public function getSearchingCategories($query)
    {
        $categoryList = null;

        if (!empty($query)) {
            $categoryList = Model::where('title', 'LIKE', '%' . $query . '%')
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->get();
        } else {
            $categoryList = Model::paginate(5);
        }

        return $categoryList;

    }

}