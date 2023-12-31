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
        $client = Role::create(['name' => 'client'])
            ->givePermissionTo(['create post']);

        //Специалист back-office может создавать/изменять обращения и просматривать клиентов
        $back_office = Role::create(['name' => 'back-office'])
            ->givePermissionTo(['create post', 'update post', 'view post', 'view user', 'leave commemt']);

        //Оператор может создавать/изменять обращения и просматривать клиентов
        $operator = Role::create(['name' => 'operator'])
            ->givePermissionTo(['create post', 'update post', 'update post status', 'view post', 'delete post', 'create user', 'update user', 'view user', 'delete user', 'leave commemt', 'change responsible']);

        //Администратору доступен весъ функционал
        $admin = Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());

        User::factory(40)->create()->each(function ($user) use ($client) {
            $user->assignRole($client);
            $user->givePermissionTo(['create post']);
        });

        User::factory(40)->create()->each(function ($user) use ($client) {
            $user->assignRole($client);
            $user->givePermissionTo(['create post']);
            $user->deleted_at = now();
            $user->save();
        });

        User::factory(20)->create()->each(function ($user) use ($back_office) {
            $user->assignRole($back_office);
            $user->givePermissionTo(['create post', 'update post', 'view post', 'view user', 'leave commemt']);
        });

        User::factory(20)->create()->each(function ($user) use ($back_office) {
            $user->assignRole($back_office);
            $user->givePermissionTo(['create post', 'update post', 'view post', 'view user', 'leave commemt']);
            $user->deleted_at = now();
            $user->save();
        });

        User::factory(10)->create()->each(function ($user) use ($operator) {
            $user->assignRole($operator);
            $user->givePermissionTo(['create post', 'update post', 'update post status', 'view post', 'delete post', 'create user', 'update user', 'view user', 'delete user', 'leave commemt', 'change responsible']);
        });

        User::factory(10)->create()->each(function ($user) use ($operator) {
            $user->assignRole($operator);
            $user->givePermissionTo(['create post', 'update post', 'update post status', 'view post', 'delete post', 'create user', 'update user', 'view user', 'delete user', 'leave commemt', 'change responsible']);
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
            'password' => '$2y$12$yWcyVBE3a2eNBVZcgvLCMugsPTuLf7d.abA1xz0TobFXzCBnUbm9.',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
        ]);
        $customUser->assignRole($admin);
        $customUser->givePermissionTo(Permission::all());

        $users = User::factory(10)
            ->create();

        $posts = Post::factory(200)
            ->recycle($users)
            ->create();

        $comments = Comment::factory(1000)->recycle($users)->recycle($posts)->create();
    }
}
