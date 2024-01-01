<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Создание разрешений
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'create post']);
        Permission::create(['name' => 'update post']);
        Permission::create(['name' => 'delete post']);
        Permission::create(['name' => 'view post']);
        Permission::create(['name' => 'leave commemt']);
        Permission::create(['name' => 'grant a role']);
        Permission::create(['name' => 'change responsible']);
        Permission::create(['name' => 'create role and permission']);

        //Клиент может создавать обращения
        $role = Role::create(['name' => 'client'])
            ->givePermissionTo(['create post']);

        //Оператор может создавать/изменять обращения и просматривать клиентов
        $role = Role::create(['name' => 'opeator'])
            ->givePermissionTo(['create post', 'update post', 'view post', 'view user']);

        //Специалист back-office может создавать/изменять обращения и просматривать клиентов
        $role = Role::create(['name' => 'back-office'])
            ->givePermissionTo(['create post', 'update post', 'view post', 'create user', 'update user', 'view user', 'leave commemt', 'grant a role', 'create role and permission']);

        //Администратору доступен весъ функционал
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
    }
}
