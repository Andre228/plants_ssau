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
        $categoryList = null;

        if($how == 'per-page') {
            $categoryList = Model::paginate(5);
        }

        if($how == 'all') {
            $categoryList = Model::all();
        }

        return $categoryList;

    }

    public function getCategoriesTree()
    {
        $categoryList = null;
        $tree = null;

        $categoryList = Model::select(['id', 'parent_id', 'title', 'updated_at'])->get();
        $tree = $this->buildTree($categoryList->toArray());

        return $tree;

    }

    private function buildTree(array $elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
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

    public function getCategoriesBaseInfo()
    {
        $columns = [
            'id',
            'title',
            'updated_at',
            'description'
        ];

        $categoryList = $this->startConditions()
            ->select($columns)
            ->toBase()
            ->get();

        return $categoryList;
    }

    public function getCategoryByName($name)
    {
        $category = Model::where('title', $name)->get()->toArray();
        return $category ? $category : null;
    }

    public function getChildrenCategories($id)
    {

        $query = "select * from (select * from museum_categories order by parent_id, id) museum_categories, 
                  (select @pv := $id) initialisation where find_in_set(parent_id, @pv) > 0 and @pv := concat(@pv, ',', id)";

        $childrenOfCategory = DB::select($query);

        return $childrenOfCategory;
    }

    public function deleteListCategories($ids)
    {
        $result = false;

        if (!empty($ids)) {
            $result = $this->startConditions()->whereIn('id', $ids)->forceDelete();
        }

        return $result;

    }

}