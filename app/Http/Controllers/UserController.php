<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Model\Post;
use App\Model\Role;
use App\Model\User;
use App\Transformer\UserTransformer;
use Illuminate\Http\Request;
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

    public function getListUser()
    {
        return User::all();
    }


    public function searchUser(Request $request)
    {
        $postName = $request->get('postName');
        $name = $request->get('name');
        $email = $request->get('email');
        $typeSort = $request->get('typeSort');
        $sortBy = $request->get('sortBy');
        $perPage = $request->get('perPage');

        $users = User::WhereHas('posts',function($query) use ($postName, $name, $email) {
            $query->where('title','LIKE',"%{$postName}%");
        })->with(['posts' => function($query) use ($postName) {
                $query->get();
        }])->where(function($query) use($request, $name, $email) {
                $query->where('name', 'LIKE',"%{$name}%")
                    ->Where('email', 'LIKE', "%{$email}%");})->paginate($perPage);

        if($typeSort == 1){
            $users = $users->sortBy($sortBy);
        }else if($typeSort == 0){
            $users = $users->sortByDesc($sortBy);
        }else{
            dd('Type sort wrong! Input 0: DESC, 1: ASC');
        }

        return response()->json([
                'data' => $users
        ]);

    }

}
