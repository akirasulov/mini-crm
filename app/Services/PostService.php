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
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PostService
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): array
    {
        auth()->user()->hasPermissionTo('view post')
        ? true : abort(403, 'Нет доступа');

        $posts = Post::with('user', 'operator');

        if (auth()->user()->hasRole('operator')) {
            $posts = $posts->where('operator_id', auth()->user()->id);
        }

        if (auth()->user()->hasRole('client')) {
            $posts = $posts->where('user_id', auth()->user()->id);
        }

        return [
            'filters' => $request->all(),
            'posts' => $posts
                ->orderByStatus()
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
        $user = User::withCount('posts')->whereHas('posts', function (Builder $query) {
            $query->where('status', Post::STATUS_PROGRESS);
        })->having('posts_count', '<', 3)->get()->random();

        auth()->user()->postsAsClinet()->create([
            'operator_id' => $user->id,
            'title' => $request->title,
            'body' => $request->body,
            'uuid' => Str::uuid(),
            'fullname' => $request->fullname,
            'title' => $request->title,
            'msisdn' => $request->msisdn,
            'status' => Post::STATUS_PROGRESS,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        auth()->user()->hasPermissionTo('update post')
        ? true : abort(403, 'Нет доступа');

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
    public function destroy(Post $post): void
    {
        $post->delete();
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Post $post): void
    {
        $post->restore();
    }

    public function export()
    {
        return Excel::download(new PostsExport, 'posts.xlsx');
    }

}
