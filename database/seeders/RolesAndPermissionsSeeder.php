<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Очищяем кэш
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Создание разрешений
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'create post']);
        Permission::create(['name' => 'update post']);
        Permission::create(['name' => 'update post status']);
        Permission::create(['name' => 'delete post']);
        Permission::create(['name' => 'view post']);
        Permission::create(['name' => 'leave commemt']);
        Permission::create(['name' => 'grant a role']);
        Permission::create(['name' => 'change responsible']);
        Permission::create(['name' => 'create role and permission']);

        //Клиент может создавать обращения
        $client_permissions = ['create post'];
        $client = Role::create(['name' => 'client'])
            ->givePermissionTo($client_permissions);

        //Специалист back-office может создавать/изменять обращения и просматривать клиентов
        $operator_permissions = ['create post', 'view post'];
        $operator = Role::create(['name' => 'operator'])
            ->givePermissionTo($operator_permissions);

        //Оператор может создавать/изменять обращения и просматривать клиентов
        $back_office_permissions = ['create post', 'update post', 'update post status', 'view post', 'view user', 'leave commemt', 'change responsible'];
        $back_office = Role::create(['name' => 'back-office'])
            ->givePermissionTo($back_office_permissions);

        //Администратору доступен весъ функционал
        $admin = Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());

        $clients = User::factory(40)->create()->each(function ($user) use ($client, $client_permissions) {
            $user->assignRole($client);
            $user->givePermissionTo($client_permissions);
        });

        User::factory(40)->create()->each(function ($user) use ($client, $client_permissions) {
            $user->assignRole($client);
            $user->givePermissionTo($client_permissions);
            $user->deleted_at = now();
            $user->save();
        });

        $back_office_users = User::factory(20)->create()->each(function ($user) use ($back_office, $back_office_permissions) {
            $user->assignRole($back_office);
            $user->givePermissionTo($back_office_permissions);
        });

        User::factory(20)->create()->each(function ($user) use ($back_office, $back_office_permissions) {
            $user->assignRole($back_office);
            $user->givePermissionTo($back_office_permissions);
            $user->deleted_at = now();
            $user->save();
        });

        User::factory(20)->create()->each(function ($user) use ($operator, $operator_permissions) {
            $user->assignRole($operator);
            $user->givePermissionTo($operator_permissions);
        });

        User::factory(20)->create()->each(function ($user) use ($operator, $operator_permissions) {
            $user->assignRole($operator);
            $user->givePermissionTo($operator_permissions);
            $user->deleted_at = now();
            $user->save();
        });

        User::factory(3)->create()->each(function ($user) use ($admin) {
            $user->assignRole($admin);
            $user->givePermissionTo(Permission::all());
            $user->deleted_at = now();
            $user->save();
        });

        User::factory(3)->create()->each(function ($user) use ($admin) {
            $user->assignRole($admin);
            $user->givePermissionTo(Permission::all());
        });

        $customUser = User::factory()->create([
            'name' => 'Akmal',
            'surname' => 'Rasulov',
            'email' => 'akirasulov2323@gmail.com',
            'login' => 'akirasulov',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
        ]);
        $customUser->assignRole($admin);
        $customUser->givePermissionTo(Permission::all());

        $posts = Post::factory(200)
            ->recycle($clients)
            ->create();

        Comment::factory(1000)->recycle($back_office_users)->recycle($posts)->create();
    }
}
