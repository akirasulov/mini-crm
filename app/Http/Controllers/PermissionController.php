<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        return inertia()->render('Admin/RoleAndPermission/Index', []);
    }

    public function create()
    {
        return inertia()->render('Admin/RoleAndPermission/Create', []);
    }

    public function storeRole()
    {
        request()->validate([
            'name' => ['required'],
        ]);

        Role::create(['name' => request('name')]);
    }

    public function sync()
    {
        return inertia()->render('Admin/RoleAndPermission/Sync', [
            'roles' => Role::with('permissions')->get(),
            'permissions' => Permission::all(),
        ]);

    }

    public function remove()
    {
        $role = Role::findById(request('role'));
        $permission = Permission::findById(request('permission'));
        $role->revokePermissionTo($permission);

    }

    public function assign(): void
    {
        $role = Role::findById(request('role'));
        $permission = Permission::findById(request('permission'));

        $role->givePermissionTo($permission);

    }

    public function storePermission()
    {
        Permission::create(['name' => request('name')]);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
    }
}
