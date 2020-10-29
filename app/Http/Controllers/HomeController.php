<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showUserForAdminPage()
    {
        $userList = (new UserController)->getListUser();
        $roleList = (new RoleController)->getListRole();
        return view('admin.user', ['user' =>$userList, 'role' => $roleList]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRoleForAdminPage()
    {
        $roleList = (new RoleController)->getListRole();
        return view('admin.role', ['data'=>$roleList]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAdmin()
    {

        return view('admin.main');
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function doLogin(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email','password'))) {
            $data['user'] = User::where('email', $request->get('email'))->first();
            $roles = User::find($data['user']->id)->roles()->get();
            foreach($roles as $role){
                $listRole[] = $role->name;
            }
            session(['roles' => $listRole]);
            return redirect()->route('viewProfile', ['id'=>$data['user']->id]);
        } else {
            session()->flash('message', 'Something wrong!');
            return view('login');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProfile($id)
    {
        $data['user']= User::find($id);
        return view('profile',$data);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doLogout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('roles');
        return Redirect::to('/');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegister()
    {
        return view('register');
    }
}
