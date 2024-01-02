<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): Response
    {
       

        return inertia()->render('Users/Index', $this->userService->index($request));
    }

    public function create(UserCreateRequest $request): Response
    {
        return inertia()->render('Users/Create', $this->userService->create());
    }

    public function store(UserStoreRequest $request): RedirectResponse
    {
        $this->userService->store($request);

        return redirect()->route('users.index')->with('success', 'Успешно!');
    }

    public function edit(User $user): Response
    {
        return inertia()->render('Users/Edit', $this->userService->edit($user));
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $this->userService->update($request, $user);

        return back()->with('success', 'Успешно!');
    }

    public function updateAvatar(UpdateAvatarRequest $request, User $user): RedirectResponse
    {
        $this->userService->updateAvatar($request, $user);

        return back()->with('success', 'Успешно!');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->userService->destroy($user);

        return redirect()->route('users.index')->with('success', 'Успешно!');
    }

    public function restore(User $user): RedirectResponse
    {
        $this->userService->restore($user);

        return back()->with('success', 'Успешно!');
    }

    public function assignRole(User $user): RedirectResponse
    {
        $userRoles = $user->getRoleNames();
        if (count($userRoles) >= 1 && request('checked')) {
            return back()->with('warning', 'У пользователя может быть только одна роль!');
        }

        $this->userService->assignRole($user);

        return back()->with('success', 'Успешно!');
    }

    public function assignPermission(User $user): RedirectResponse
    {
        $this->userService->assignPermission($user);

        return back()->with('success', 'Успешно!');
    }
}
