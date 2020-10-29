<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\RoleRequest;
use App\Model\Role;
use App\Model\User;
use Illuminate\Support\Facades\Auth;

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
        Role::find($idRole)->delete();
        return redirect()->route('admin.role');
    }

    /**
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addRoleToUser(RoleRequest $request)
    {
        $idUser = $request->get('user');
        $idRole = $request->get('role');
        $createdBy = User::find(Auth::id())->name;
        $user = User::find($idUser);
        $user->roles()
            ->attach(Role::where('id', $idRole)->first(), ['created_by' =>$createdBy]);
        return redirect()->route('admin');
    }

    /**
     * @param RoleRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addRole(RoleRequest $request)
    {
        Role::create(['name'=> $request->get('role')]);
        session()->flash('message', 'Role is created');
        return redirect()->route('admin');
    }

    public function getListRole()
    {
        return Role::all();
    }

}
