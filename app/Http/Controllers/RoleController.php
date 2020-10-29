<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RoleRequest;
use App\Model\Category;
use App\Model\Role;
use App\Model\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{

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
    public function addRoleToUser()
    {
        $user = User::find(Auth::user()->getAuthIdentifier());
        $user->roles()
            ->attach(Role::where('name', 'editor')->first(), ['created_by' =>'server']);
    }

    /**
     * @param RoleRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addRole(RoleRequest $request)
    {
        dd($request->all());
        Role::create(['name'=> $request->get('role')]);
        session()->flash('message', 'Role is created');
        return redirect()->route('admin');
    }

    public function getListRole()
    {
        return Role::all();
    }

}
