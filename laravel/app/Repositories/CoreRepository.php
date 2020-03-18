<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 17.03.2020
 * Time: 21:05
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;


abstract class CoreRepository
{

    protected $model;


    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }


    abstract protected function getModelClass();



    protected function startConditions()
    {
        return clone $this->model;
    }
}