<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Model\Category;
use App\Model\Post;
use App\Model\Tag;
use App\Model\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Traits\UploadTrait;

class PostController extends Controller
{
    use UploadTrait;

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showListPost()
    {
        $data = $this->getListPost();
        return view('admin.list', ['data' => $data]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showViewCreatePost()
    {
        return view('post.create', ['data' => $this->getListNameCategory()]);
    }

    /**
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     */
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
        $arrayTag= $data->tags()->get();
        $data['tag'] = $this->concatenateStringFromArray($arrayTag);
        return view('admin.editPost', ['data' => $data]);
    }

    /**
     * @param $array
     * @return string
     */
    public function concatenateStringFromArray($array): string
    {
        $nameTag = [];
        foreach ($array as $item){
            $nameTag = $item->name;
        }
        $string = implode(', ', $nameTag );
        return $string;
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
            // Check tag if dont exists => Create. else get id from name
            $tag = explode(', ', $request->get('tag'));

            $tagID = $this->getListTagIdByTagName($tag);


            $image = $request->file('image');
            $filePath = (new ImageController)->saveImage($image);

            $post = Post::create([
                'user_id' => $user_id,
                'category_id' => $request->get('categories'),
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'link' => $request->get('link'),
                'image_path' => $filePath,
                'created_at' => now(),
            ]);

            $post->tags()->attach($tagID);
            session()->flash('message', 'Your post has been posted');

            return redirect()->route('viewListPost');
        }
    }


    /**
     * @param $arrayTagName
     * @return array
     */
    public function getListTagIdByTagName($arrayTagName){
        $arrayTagID = [];
        for($i = 0; $i < sizeof($arrayTagName); $i++){
            if(!$this->checkTagIsExists($arrayTagName[$i])){
                $itemTag = Tag::create(['name'=> $arrayTagName[$i]]);
                array_push($arrayTagID, $itemTag->id);
            }else{
                array_push($arrayTagID,Tag::where('name',$arrayTagName[$i])->first()->id);
            }
        }
        return $arrayTagID;
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
            $tagName = explode(', ', $request->get('tag'));
            $tagID = $this->getListTagIdByTagName($tagName);

            $image = $request->file('image');
            $filePath = (new ImageController)->saveImage($image);

            Post::where('id', $id)
                ->update([
                    'title' => $request->get('title'),
                    'description' => $request->get('description'),
                    'link' => ($request->get('link')),
                    'image_path' => $filePath
                ]);

            Post::findorFail($id)->tags()->sync($tagID);
//            $post->tags()->attach($tagID);
            session()->flash('message', 'Your post is updated');
            return redirect()->route('viewListPost');
        }
    }


    /**
     * @param $idCategory
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListPostByCategoryId($idCategory)
    {
        $data['listPost'] = Category::find($idCategory)->posts()->paginate(4);
        $data['nameCategory'] = Category::find($idCategory);
        return view('post.category', ['data' => $data]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePost($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();
        $post->tags()->detach();

        return redirect()->route('viewListPost');
    }

    /**
     * @param $tag
     * Exists => return true;
     * @return bool
     */
    function checkTagIsExists($tag)
    {
        $tagIsExists = Tag::where('name',$tag)->first();
        if(is_null($tagIsExists)){
            return false;
        }
        return true;
    }




}
