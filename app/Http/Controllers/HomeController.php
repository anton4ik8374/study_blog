<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::where('status',0)->paginate(2);


        return view('pages.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug',$slug)->firstOrFail();

        return view('pages.show', compact('post'));
    }
}
