<?php

namespace App\Http\Controllers;

use App\Model\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function showListPost(){
        $data = $this->getListPost();
        return view('post.list',['data' => $data]);
    }
    public function showViewCreatePost(){
        return view('post.create',['name' => 'James']);
    }
    public function createPost(Request $request){
        $rules = array(
            'title'     => 'bail|required',
            'description'    => 'bail|required',
            'link' => 'bail|required',
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('post/create')
                ->withErrors($validator);
        } else {
            $user_id = Auth::id();
            if(!$user_id) {
                session()->flash('message', 'Please login first !!');
                return Redirect::to('post/create');
            }else {
                Post::create([
                    'user_id' => $user_id,
                    'title' => $request->get('title'),
                    'description' => $request->get('description'),
                    'link' => $request->get('link'),
                    'created_at' => now(),
                ]);
                session()->flash('message', 'Your post has been posted');
                DB::commit();

                return redirect()->route('viewListPost');
            }

        }
    }

    public function getListPost(){
        $post = DB::table('posts')
            ->select()->get();

        return $post;
    }

}
