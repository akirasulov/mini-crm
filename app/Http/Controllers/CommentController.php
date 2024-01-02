<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CommentStoreRequest $request, Post $post)
    {
        $post->comments()->create([
            'body' => $request->body,
            'user_id' => auth()->user()->id,
        ]);

        return back()->with('success', 'Успешно!');
    }
}
