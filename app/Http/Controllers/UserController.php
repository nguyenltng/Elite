<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function create(Request $request)
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
            $uuid = Str::uuid();
            $mytime = Carbon::now();
            User::create([
                    'id'=> $uuid,
                    'name'=> $request->get('name'),
                    'email'=> $request->get('email'),
                    'password' => Hash::make($request->get('password')),
                    'created_at' =>$mytime,
                    'remember_token' => Str::random(10),
            ]);
            session()->flash('message', 'Your account is created');
            DB::commit();

            return redirect()->route('register');

        }
    }

    public function update(Request $request, $id){
        $password = Auth::user()->getAuthPassword();  //  where('email', $request->get('email'));
        $rules = array(
            'name'     => 'bail|required',
            'email'    => 'bail|required|email',
            'password' => 'bail|required|alphaNum|min:3',
            'oldPassword' => 'bail|required'
        );
        $data['id'] = Auth::id();

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('viewProfile',['id'=>$data['id']])
                ->withErrors($validator)
                ->withInput($request->except('password'));
        } else if(!Hash::check($request->get('oldPassword'), $password)) {
            session()->flash('message', 'Old Password Dont Match Current Password');
            return redirect()->route('viewProfile', ['id' => $data['id']]);
        }    else{
            $id = Auth::user()->getAuthIdentifier();
            DB::beginTransaction();

            DB::table('users')
                ->where('id', Auth::id() )
                ->update([
                    'name'=> $request->get('name'),
                    'email'=> $request->get('email'),
                    'password' => Hash::make($request->get('password')),
            ]);
            session()->flash('message', 'Your account is updated');
            DB::commit();
            return  redirect()->route('viewProfile',['id'=>$data['id']]);
        }
    }

}
