<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Post\Put;
use App\Http\Requests\Post\Store;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    
    public function index(){
        $posts = Post::paginate(2);
        return inertia("Dashboard/Post/Index", compact("posts"));
    }    
    
    public function create()
    {
        $categories = Category::get();
        return inertia('Dashboard/Post/Create', compact('categories'));
    }

    public function store(Store $request)
    {
        $post = Post::create($request->validated());
        $this->upload($request, $post);
        return to_route('post.index')->with('message', "Create post successfully");
    }

    public function edit(Post $post)
    {
        $categories = Category::get();
        return inertia('Dashboard/Post/Save', compact('post','categories'));
    }

    public function update(Put $request, Post $post)
    {
        $post->update($request->validated());
        $this->upload($request, $post);
        return redirect()->route('post.index')->with('message', "Updated post successfully");
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return to_route('post.index')->with('message', "Updated post successfully");
    }

    public function upload(Request $request, Post $post)
    {
        $request->validate(
            [
                'image' => 'required|mimes:jpg,jpeg,png,gif|max:10240'
            ]
        );

        Storage::disk("public_upload")->delete("image/post/".$post->image);

        $data['image'] = $filename = time().".".$request['image']->extension();

        $request->image->move(public_path("image/post"),$filename);

        $post->update($data);
        return to_route('post.index')->with('message',"Upload image to post successfully");

    }

    public function deleteImage(Post $post)
    {
        Storage::disk("public_upload")->delete("image/post/".$post->image);
        $post->update(['image' => '']);
        return to_route('post.edit', $post->id)->with('message', "Image removed to post successfully");
    }
}
