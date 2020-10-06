<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'email'    => 'required|email',
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
                'email'     => $request->get('email'),
                'password'  => $request->get('password')
            );
            // attempt to do the login
            if (Auth::attempt($userdata)) {
                $message  = 'SUCCESS!';
                return redirect()->route('profile')->with($message);

            } else {
                // validation not successful
                return Redirect::to('login');

            }

        }
    }
    public function doLogout()
    {
        Auth::logout(); // log the user out of our application
        return Redirect::to('login'); // redirect the user to the login screen
    }
    public function showRegister()
    {
        return View::make('register');
    }
}
