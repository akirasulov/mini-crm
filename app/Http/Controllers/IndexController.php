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
        $posts = Post::with('operator')
            ->where('user_id', $request->user()->id)
            ->paginate(10)
            ->withQueryString()
            ->through(fn($post) => [
                'id' => $post->id,
                'uuid' => $post->uuid,
                'fullname' => $post->fullname,
                'operator' => $post->operator->fullname,
                'title' => $post->title,
                'msisdn' => $post->msisdn,
                'status' => $post->status,
                'created_at' => $post->created_at->format('d-m-Y'),
            ]);

        return inertia()->render('Index', [
            'posts' => $posts,
        ]);
    }
}
