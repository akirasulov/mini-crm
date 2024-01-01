<?php

namespace App\Services;

use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserService
{
    public function index(Request $request): array
    {
        return [
            'filters' => $request->all(),
            'users' => User::with('media')
                ->orderByName()
                ->filter($request->only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn($user) => [
                    'id' => $user->id,
                    'fullname' => $user->fullname,
                    'login' => $user->login,
                    'email' => $user->email,
                    'profile_photo_path' => $user->hasMedia('images') ? $user->getMedia('images')->first()->getFullUrl() : false,
                    'last_seen' => $user->updated_at->diffForHumans(),
                    'deleted_at' => $user->deleted_at,
                ]),
        ];
    }

    public function create(): array
    {
        return [
            'roles' => Role::all(),
            'permissions' => Permission::all(),
        ];
    }

    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->only('name', 'surname', 'login', 'password', 'email'));

        if (!empty($request->roles)) {
            $user->syncRoles($request->roles);
        }

        if (!empty($request->permissions)) {
            $user->syncPermissions($request->permissions);
        }
    }

    public function edit(User $user): array
    {
        return [
            'user' => UserResource::make($user->load('roles', 'permissions', 'media')),
            'roles' => Role::all(),
            'permissions' => Permission::all(),
        ];
    }

    public function update(UserUpdateRequest $request, User $user)
    {

        if ($request->password) {
            $user->update(['password' => $request->password]);
        }

        if ($request->password) {
            $user->update(['password' => $request->password]);
        }

        $user->update($request->only('name', 'surname', 'login', 'email'));
    }

    public function updateAvatar(UpdateAvatarRequest $request, User $user)
    {

        if ($user->profile_photo_path) {
            $getMedia = $user->getMedia('images')->first();
            $getMedia->delete();
        }
        $media = $user->addMediaFromRequest('profile_photo_path')->toMediaCollection('images');

        $user->update(['profile_photo_path' => $media->file_name]);

    }

    public function destroy(User $user)
    {
        $user->delete();
    }

    public function restore(User $user)
    {
        $user->restore();
    }

    public function assignRole(User $user)
    {
        request()->validate(['role_name' => 'required']);

        if (request('checked')) {
            $user->assignRole(request('role_name'));
        } else {
            $user->removeRole(request('role_name'));
        }
    }

    public function assignPermission(User $user)
    {
        request()->validate(['permission_name' => 'required']);

        if (request('checked')) {
            $user->givePermissionTo(request('permission_name'));
        } else {
            $user->revokePermissionTo(request('permission_name'));
        }
    }

}
