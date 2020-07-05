<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 21.06.2020
 * Time: 18:48
 */

namespace App\Repositories;

use App\Models\User as Model;
use PhpParser\Node\Expr\Cast\Object_;


class MuseumUserRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    public function getAllUsers()
    {
        $columns = [
            'id',
            'name',
            'email',
            'role',
            'created_at'
        ];

        $result = $this
            ->startConditions()
            ->select($columns)
            ->toBase()
            ->get();

        return $result;
    }

    public function getAllWithPaginate($howMuch = null)
    {
        $columns = [
            'id',
            'name',
            'email',
            'role',
            'created_at'
        ];

        if ($howMuch !== null) {
            $result = $this->startConditions()
                ->select($columns)
                ->paginate($howMuch);
        }

        else {
            $result = $this->startConditions()
                ->select($columns)
                ->get();
        }


        return $result;
    }

}