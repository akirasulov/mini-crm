<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        return inertia()->render('Users/Index', $this->userService->index($request));
    }

    public function create()
    {
        return inertia()->render('Users/Create', $this->userService->create());
    }

    public function store(UserStoreRequest $request)
    {
        $this->userService->store($request);

        return redirect()->route('users.index')->with('success', 'Успешно!');
    }

    public function edit(User $user)
    {
        return inertia()->render('Users/Edit', $this->userService->edit($user));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $this->userService->update($request, $user);

        return back()->with('success', 'Успешно!');
    }

    public function destroy(User $user)
    {
        $this->userService->destroy($user);

        return redirect()->route('users.index')->with('success', 'Успешно!');
    }

    public function restore(User $user)
    {
        $this->userService->restore($user);

        return back()->with('success', 'Успешно!');
    }

    public function assignRole(User $user)
    {
        $this->userService->assignRole($user);

        return back()->with('success', 'Успешно!');
    }

    public function assignPermission(User $user)
    {
        $this->userService->assignPermission($user);

        return back()->with('success', 'Успешно!');

    }
}
