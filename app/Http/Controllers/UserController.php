<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Model\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    /**
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

        return redirect()->route('register');

    }

    /**
     * @param UpdateUserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, $id){
        $password = Auth::user()->getAuthPassword();  //  where('email', $request->get('email'));
        $data['id'] = Auth::id();
        if(!Hash::check($request->get('oldPassword'), $password)) {
            session()->flash('message', 'Old Password Dont Match Current Password');
            return redirect()->route('viewProfile', ['id' => $data['id']]);
        }else{
            User::where('id', Auth::id() )
                ->update([
                    'name'=> $request->get('name'),
                    'email'=> $request->get('email'),
                    'password' => Hash::make($request->get('password')),
            ]);
            session()->flash('message', 'Your account is updated');

            return  redirect()->route('viewProfile',['id'=>$data['id']]);
        }
    }

}
