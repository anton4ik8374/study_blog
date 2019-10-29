<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Events\ImagMiniEvent;
use App\Models\Post;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('title', 'id')->all();

        $tags = Tag::pluck('title', 'id')->all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = Post::add($request->all());

        if($request->hasFile('image')) {

            $name = $post->uploadImage($request->file('image'));

            event(new ImagMiniEvent($name, 'posts'));

            $post->setCategory($request->get('category_id'));

            $post->setTags($request->get('tags'));

            $post->toggleStatus($request->get('status'));

            $post->toggleFetured($request->get('is_featured'));
        }

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        $categories = Category::pluck('title', 'id')->all();

        $tags = Tag::pluck('title', 'id')->all();

        $selectedTags = $post->tags->pluck('id')->all();


        return view('admin.posts.edit', compact('categories', 'tags', 'post', 'selectedTags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);

        $oldFileName = $post->image;

        $post->edit($request->all());

        if($request->hasFile('image')) {

            if($oldFileName !== null) {

                $post->deleteImages($oldFileName);

                $post->deleteMiniImages($oldFileName);
            }
            $name = $post->uploadImage($request->file('image'));

            event(new ImagMiniEvent($name, 'posts'));
        }
        $post->setCategory($request->get('category_id'));

        $post->setTags($request->get('tags'));

        $post->toggleStatus($request->get('status'));

        $post->toggleFetured($request->get('is_featured'));

        return redirect()->route('posts.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id)->remove();

        return redirect()->route('posts.index');
    }
}
