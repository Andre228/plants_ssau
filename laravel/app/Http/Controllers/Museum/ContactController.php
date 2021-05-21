<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 21.05.2021
 * Time: 21:38
 */

namespace App\Http\Controllers\Museum;

class ContactController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('museum.contact.index');
    }

}