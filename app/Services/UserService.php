<?php

namespace App\Services;

use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserService
{
    public function index(Request $request): array
    {
        auth()->user()->hasPermissionTo('view user')
        ? true : abort(403, 'Нет доступа');

        $users = User::with('media');

        if (!auth()->user()->hasAnyRole(['admin', 'back-office'])) {
            $users = $users->whereHas('roles', function (Builder $query) {
                $query->where('name', 'client');
            });
        }

        return [
            'filters' => $request->all(),
            'users' => $users
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
                    'is_online' => Cache::has('user-online' . $user->id),
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

    public function store(UserStoreRequest $request): void
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

    public function update(UserUpdateRequest $request, User $user): void
    {

        if ($request->password) {
            $user->update(['password' => $request->password]);
        }

        if ($request->password) {
            $user->update(['password' => $request->password]);
        }

        $user->update($request->only('name', 'surname', 'login', 'email'));
    }

    public function updateAvatar(UpdateAvatarRequest $request, User $user): void
    {

        if ($user->profile_photo_path) {
            $getMedia = $user->getMedia('images')->first();
            $getMedia->delete();
        }
        $media = $user->addMediaFromRequest('profile_photo_path')->toMediaCollection('images');

        $user->update(['profile_photo_path' => $media->file_name]);

    }

    public function destroy(User $user): void
    {
        $user->delete();
    }

    public function restore(User $user): void
    {
        $user->restore();
    }

    public function assignRole(User $user): void
    {
        request()->validate(['role_name' => 'required']);

        if (request('checked')) {

            // Присваиваем роль пользователю
            $user->assignRole(request('role_name'));
            // Получить все роли пользователя

            $roles = $user->roles;
            // Получить все permissions, синхронизированные с ролями
            $permissions = $roles->pluck('permissions');
            // Присвоить разрешения пользователю
            $user->givePermissionTo($permissions);
        } else {
            // Получить все permissions пользователя
            $permissions = $user->permissions;
            // Удалить все permissions
            foreach ($permissions as $permission) {
                $user->revokePermissionTo(request($permission->name));
            }
            $user->removeRole(request('role_name'));
        }
    }

    public function assignPermission(User $user): void
    {
        request()->validate(['permission_name' => 'required']);

        if (request('checked')) {
            $user->givePermissionTo(request('permission_name'));
        } else {
            $user->revokePermissionTo(request('permission_name'));
        }
    }

}
