<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function doRegister(Request $request)
    {
        $rules = array(
            'name'     => 'bail|required',
            'email'    => 'bail|required|email',
            'password' => 'bail|required|alphaNum|min:3',
            'passwordConfirm' => 'bail|required|same:password'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('register')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        } else {
            // create our user data for the authentication
//            $userdata = array(
//                'name'      => $request->get('name'),
//                'email'     => $request->get('email'),
//                'password'  => $request->get('password'),
//            );
            $uuid = Str::uuid()->toString();
            DB::table('users')->insert([
                [
                    'id'=>$uuid,
                    'name'=> $request->get('name'),
                    'email'=> $request->get('email'),
                    'password' => Hash::make($request->get('password')) ],
            ]);
            session()->flash('message', 'Your account is created');

            return redirect()->route('register');

        }
    }
}
