<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function destroy(): void
    {

        $role = Role::find(request('role'));
        $role->permissions()->detach();
    }

}
