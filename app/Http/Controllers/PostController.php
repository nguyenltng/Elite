<?php

namespace App\Http\Controllers;

use App\Model\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function showListPost(){
        return view('post.list');
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
            return Redirect::to('view.createPost')
                ->withErrors($validator);
        } else {
            Post::create([
                'title'=> $request->get('title'),
                'description'=> $request->get('description'),
                'link'=> $request->get('link'),
                'created_at' => now(),
            ]);
            session()->flash('message', 'Your post has been posted');
            DB::commit();

            return redirect()->route('showViewPost');

        }
    }

}
