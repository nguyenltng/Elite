<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Model\Category;
use App\Model\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showListCategory()
    {
        $categoryList = Category::all();
        return view('welcome',['data' => $categoryList]);

    }

}
