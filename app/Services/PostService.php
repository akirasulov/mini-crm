<?php

namespace App\Services;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostService
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): array
    {
        return [
            'filters' => $request->all(),
            'posts' => Post::with('user', 'operator')
                ->orderById()
                ->filter($request->only('search', 'trashed', 'status'))
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
                    'created_at' => $post->created_at->format('d-m-Y h:i:s'),
                ]),
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }

}
