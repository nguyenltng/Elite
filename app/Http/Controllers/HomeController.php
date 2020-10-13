<?php

namespace App\Http\Controllers;

use App\User;
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

    public function doLogin(Request $request)
    {
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|alphaNum|min:3'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('login')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        } else {
            // create our user data for the authentication
            $userdata = array(
                'email' => $request->get('email'),
                'password' => $request->get('password')
            );
            if (Auth::attempt($userdata)) {
                //$data['id'] = Auth::id();
                $data['user'] = User::query()->where('email', $request->get('email'))->first();
                //return route('viewProfile',['id'=>Auth::id()]);
                return redirect()->route('viewProfile', ['id'=>$data['user']->id]);
            } else {
                return view('login');
            }

        }
    }
    public function showProfile($id)
    {
        $data['id'] = $id;
        $data['user']= User::find($id);
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
