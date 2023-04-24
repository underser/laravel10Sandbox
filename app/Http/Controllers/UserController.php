<?php

namespace App\Http\Controllers;

use App\Service\UserService;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function index()
    {
        return view('welcome', [
            'userList' => $this->userService->getUsersList()
        ]);
    }
}
