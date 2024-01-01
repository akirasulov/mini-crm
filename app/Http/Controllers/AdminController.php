<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function create()
    {
        return inertia()->render('Admin/CreateUser', [
            'roles' => Role::all(),
            'permissions' => Permission::all(),

        ]);
    }
}
