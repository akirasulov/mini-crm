<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $posts = Post::where('user_id', $request->user()->id)->get();
        return inertia()->render('Index', [
            'posts' => $posts,
        ]);
    }
}
