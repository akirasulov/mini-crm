<?php

namespace App\Services;

use App\Exports\PostsExport;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        $operators = User::whereHas('roles', function (Builder $query) {
            $query->whereIn('name', ['operator', 'back-office']);
        })
            ->get()
            ->transform(fn($user) => [
                'id' => $user->id,
                'fullname' => $user->fullname,
            ]);
        return [
            'post' => PostResource::make($post->load('comments', 'operator', 'user')),
            'operators' => $operators,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): void
    {
        $post->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }

    public function export()
    {
        return Excel::download(new PostsExport, 'posts.xlsx');
    }

}
