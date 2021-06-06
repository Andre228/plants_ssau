<?php

namespace App\Http\Controllers\Museum;

use App\Repositories\MuseumCategoryRepository;
use App\Repositories\MuseumPostRepository;;

class CategoryController extends BaseController
{

    private $museumCategoryRepository;
    private $museumPostRepository;

    public function __construct()
    {
        parent::__construct();

        $this->museumCategoryRepository = app(MuseumCategoryRepository::class);
        $this->museumPostRepository = app(MuseumPostRepository::class);
    }

    public function index()
    {
        $categoriesList = $this->museumCategoryRepository->getCategoriesBaseInfo();
        $categoriesTree = json_encode($this->museumCategoryRepository->getCategoriesTree());

        return view('museum.category.index', compact('categoriesList', 'categoriesTree'));
    }

    public function getPosts($id, $state)
    {
        if ($state === 'new') {
            $posts = $this->museumPostRepository->getPostsByCategoryId($id);
        }

        if ($state === 'old') {
            $posts = $this->museumPostRepository->getPostsByCategoryId($id, false, true);
        }

        if (!empty($posts)) {
            return response(['posts' => $posts, 'status' => 'OK']);
        } else {
            return response(['message' => 'Ошибка получения данных', 'status' => 'ERROR']);
        }


    }
}
