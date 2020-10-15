<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Model\User;
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

    public function create(CreateUserRequest $request)
    {
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

    public function update(UpdateUserRequest $request, $id){
        $password = Auth::user()->getAuthPassword();  //  where('email', $request->get('email'));
        $data['id'] = Auth::id();
        if(!Hash::check($request->get('oldPassword'), $password)) {
            session()->flash('message', 'Old Password Dont Match Current Password');
            return redirect()->route('viewProfile', ['id' => $data['id']]);
        }else{
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
