<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Model\Category;
use App\Model\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showListPost()
    {
        $data = $this->getListPost();
        return view('post.list', ['data' => $data]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showViewCreatePost()
    {
        return view('post.create',['data' => $this->getListNameCategory()] );
    }

    public function getListNameCategory()
    {
        return Category::all();
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
        $post = Post::paginate(5);
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
                'category_id'=> $request->get('categories'),
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'link' => $request->get('link'),
                'created_at' => now(),
            ]);
            session()->flash('message', 'Your post has been posted');

            return redirect()->route('viewListPost');
        }
    }

    /**
     * @param UpdatePostRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editPost(UpdatePostRequest $request, $id)
    {
        $user_id = Auth::id();
        if (!$user_id) {
            session()->flash('message', 'Please login first !!');
            return redirect()->route('view.editPost', ['id' => $id]);
        } else {
            Post::where('id', $id)
                ->update([
                    'title' => $request->get('title'),
                    'description' => $request->get('description'),
                    'link' => ($request->get('link')),
                ]);
            session()->flash('message', 'Your post is updated');

            return redirect()->route('viewListPost');
        }
    }

    /**
     * @param $idCategory
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListPostByCategoryId($idCategory){
        $listPost = Post::query()->where('category_id', $idCategory)->paginate(5);
        return view('post.category', ['data' =>$listPost]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePost($id)
    {
        Post::where('id', $id)
            ->delete();
        return redirect()->route('viewListPost');
    }

}
