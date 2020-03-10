<?php

namespace App\Http\Controllers\Museum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    static public function index() {

        $user = \Auth::user();

        return view('layouts.app', compact('user'));
    }
}
