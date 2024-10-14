<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Post\Put;
use App\Http\Requests\Post\Store;
use App\Http\Controllers\Controller;

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
        Post::create($request->validated());
        return to_route('post.index')->with('message', "Create post successfully");
    }

    public function edit(Post $post)
    {
        $categories = Category::get();
        return inertia('Dashboard/Post/Edit', compact('post','categories'));
    }

    public function update(Put $request, Post $post)
    {
        $post->update($request->validated());
        return redirect()->route('post.index')->with('message', "Updated post successfully");
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return to_route('post.index')->with('message', "Updated post successfully");
    }
}
