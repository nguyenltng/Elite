<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Model\Post;
use App\Model\Role;
use App\Model\User;
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


    public function searchUser(SearchRequest $request)
    {
        $column = $request->get('column');
        $searchText = $request->get('q');
        $sortBy = $request->get('sortBy');
        $typeSort = $request->get('typeSort');
        $fromDate = $request->get('fromDate');
        $toDate = $request->get('toDate');
        $perPage = $request->get('perPage');
        $users = User::whereHas('posts',function($query) use ($fromDate, $toDate, $searchText, $column) {
            $query->where($column,'LIKE',"%{$searchText}%")
                ->whereBetween('created_at',[$fromDate, $toDate]);
        })
            ->with(['posts' => function($query) use ($searchText, $column) {
                $query->get();}])->paginate($perPage);
        if($typeSort == 0){
            $users = $users->sortBy($sortBy);
        }else if($typeSort == 1){
            $users = $users->sortByDesc($sortBy);
        }else{
            dd('Type sort wrong! Input:  0 = ASC, 1 = DESC');
        }


        return response()->json([
            'data' => $users
        ]);

    }

}
