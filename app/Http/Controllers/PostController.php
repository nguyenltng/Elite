<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Model\Post;
use App\Model\User;
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
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showListPost()
    {
        $data = $this->getListPost();
        $data = DB::table('posts')->paginate(5);

        return view('post.list', ['data' => $data]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showViewCreatePost()
    {
        return view('post.create', ['name' => 'James']);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showViewEditPost($id)
    {
        $data = Post::find($id);
        return view('post.edit', ['data' => $data]);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getListPost()
    {
        $post = DB::table('posts')->paginate(5);
        return $post;
    }

    /**
     * @param CreatePostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createPost(CreatePostRequest $request)
    {
        $user_id = Auth::id();
        if (!$user_id) {
            session()->flash('message', 'Please login first !!');
            return Redirect::to('post/create');
        } else {
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

    public function editPost(UpdatePostRequest $request, $id)
    {
        $user_id = Auth::id();
        if (!$user_id) {
            session()->flash('message', 'Please login first !!');
            return redirect()->route('view.editPost', ['id' => $id]);
        } else {
            DB::beginTransaction();
            DB::table('posts')
                ->where('id', $id)
                ->update([
                    'title' => $request->get('title'),
                    'description' => $request->get('description'),
                    'link' => ($request->get('link')),
                ]);
            session()->flash('message', 'Your post is updated');
            DB::commit();

            return redirect()->route('viewListPost');
        }
    }

    public function deletePost($id)
    {
        DB::beginTransaction();
        DB::table('posts')
            ->where('id', $id)
            ->delete();
        DB::commit();
        return redirect()->route('viewListPost');
    }

}
