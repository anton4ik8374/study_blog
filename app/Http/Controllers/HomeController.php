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
        $posts = Post::where('status',0)->get();

        foreach ($posts as $post){
            dd($post->author->name);
        }

        return view('pages.index', compact('posts'));
    }
}
