<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Symfony\Component\Console\Input\Input;

class HomeController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function doLogin(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email','password'))) {

            $data['user'] = User::query()->where('email', $request->get('email'))->first();
            return redirect()->route('viewProfile', ['id'=>$data['user']->id]);
        } else {
            session()->flash('message', 'Something wrong!');
            return view('login');
        }
    }
    public function showProfile($id)
    {
        $data['id'] = $id;
        $data['user']= User::query()->find($id);
        return view('profile',$data);
    }

    public function doLogout()
    {
        Auth::logout();
        return Redirect::to('/');
    }

    public function showRegister()
    {
        return view('register');
    }
}
