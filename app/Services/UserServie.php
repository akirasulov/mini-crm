<?php

namespace App\Services;

class UserService
{
    public function index()
    {
        return inertia()->render('Users/Index', []);
    }

}
