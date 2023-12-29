<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // public function __construct(private UserService $userService)
    // {
    //     $this->userService = $userService;
    // }

    public function index(Request $request)
    {
        return inertia()->render('Users/Index', [
            'filters' => $request->all(),
            'users' => User::query()
                ->orderByName()
                ->filter($request->only('search', 'trashed'))
                ->get()
                ->transform(fn($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'login' => $user->login,
                    'email' => $user->email,
                    'profile_photo_path' => $user->profile_photo_path,
                    'deleted_at' => $user->deleted_at,
                ]),
        ]);
    }

    public function create()
    {
        return inertia()->render('Users/Create');
    }

    public function store(UserStoreRequest $request)
    {}

    public function edit(User $user)
    {}

    public function update()
    {}

    public function destroyt(User $user)
    {}

    public function restore(User $user)
    {}
}
