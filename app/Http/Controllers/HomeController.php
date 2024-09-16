<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with(['user', 'comments'])->latest()->paginate(3);
        $postsData = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'start_point' => $post->start_point,
                'end_point' => $post->end_point,
                'user' => $post->user->name,
                'created_at' => $post->created_at->diffForHumans(),
            ];
        })->keyBy('id');

        if ($request->ajax()) {
            $view = view('partials._post_list', compact('posts'))->render();
            return response()->json([
                'html' => $view,
                'hasMorePages' => $posts->hasMorePages(),
                'postsData' => $postsData
            ]);
        }
        
        return view('home', compact('posts', 'postsData'));
    }
}
