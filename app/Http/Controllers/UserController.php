<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
                ->paginate(10)
                ->withQueryString()
                ->through(fn($user) => [
                    'id' => $user->id,
                    'fullname' => $user->fullname,
                    'login' => $user->login,
                    'email' => $user->email,
                    'profile_photo_path' => $user->profile_photo_path,
                    'last_seen' => $user->updated_at->diffForHumans(),
                    'deleted_at' => $user->deleted_at,
                ]),
        ]);
    }

    public function create()
    {
        return inertia()->render('Users/Create', [
            'roles' => Role::all(),
            'permissions' => Permission::all(),

        ]);
    }

    public function store(UserStoreRequest $request)
    {
        ;
        $user = User::create($request->only('name', 'surname', 'login', 'password', 'email'));

        if (!empty($request->roles)) {
            $user->syncRoles($request->roles);
        }

        if (!empty($request->permissions)) {
            $user->syncPermissions($request->permissions);
        }
        return redirect()->route('users.index')->with('success', 'Успешно!');
    }

    public function edit(User $user)
    {
        return inertia()->render('Users/Edit', [
            'user' => UserResource::make($user->load('roles', 'permissions')),
            'roles' => Role::all(),
            'permissions' => Permission::all(),
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        if ($request->password) {
            $user->update(['password' => $request->password]);
        }

        $user->update($request->only('name', 'surname', 'login', 'email'));

        return back()->with('success', 'Успешно!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Успешно!');
    }

    public function restore(User $user)
    {
        $user->restore();

        return back()->with('success', 'Успешно!');
    }

    public function assignRole(User $user)
    {
        request()->validate(['role_name' => 'required']);

        if (request('checked')) {
            $user->assignRole(request('role_name'));
        } else {
            $user->removeRole(request('role_name'));
        }
        return back()->with('success', 'Успешно!');
    }

    public function assignPermission(User $user)
    {
        request()->validate(['permission_name' => 'required']);

        if (request('checked')) {
            $user->givePermissionTo(request('permission_name'));
        } else {
            $user->revokePermissionTo(request('permission_name'));
        }
        return back()->with('success', 'Успешно!');

    }
}
