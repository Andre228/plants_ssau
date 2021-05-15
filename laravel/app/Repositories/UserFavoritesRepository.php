<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 15.05.2021
 * Time: 22:57
 */

namespace App\Repositories;

use App\Models\UserFavorites as Model;


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



}