<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Model\Post;
use App\Model\Role;
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
        $user = User::create([
                'id'=> $uuid,
                'name'=> $request->get('name'),
                'email'=> $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'created_at' => now(),
                'remember_token' => Str::random(10),
        ]);
        $user->roles()
             ->attach(Role::where('name', 'reader')->first(), ['created_by' =>'server']);
        session()->flash('message', 'Your account is created');

        return redirect()->route('register');

    }

    /**
     * @param UpdateUserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $password = Auth::user()->getAuthPassword();
        $data['id'] = Auth::id();
        if(!Hash::check($request->get('oldPassword'), $password)) {
            session()->flash('message', 'Old Password Dont Match Current Password');
            return redirect()->route('viewProfile',['id' => $data['id']]);
        }else{
            $user = User::find($data['id']);
            $user->setNameAttribute($request->get('name'));
            User::where('id', $data['id'] )
                ->update([
                    'name'=> $user->name,
                    'email'=> $request->get('email'),
                    'password' => Hash::make($request->get('password')),
            ]);
            session()->flash('message', 'Your account is updated');
            return  redirect()->route('viewProfile',['id'=>$data['id']]);
        }
    }

    /**
     * @param DeleteUserRequest $request
     * @param $idRole
     * @return mixed
     */
    public function deleteRole(DeleteUserRequest $request,$idRole)
    {
        $role = Role::findOrFail($idRole);
        $role->users()->delete();
        $role->users()->detach();
        return $role;
    }

    /**
     *
     */
    public function addRole()
    {
        $user = User::find(Auth::user()->getAuthIdentifier());
        $user->roles()
            ->attach(Role::where('name', 'writer')->first());
    }

}
