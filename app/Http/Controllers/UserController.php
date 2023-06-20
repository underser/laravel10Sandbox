<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->whereHas('projects', function (Builder $query) {
            $query->where('project_id', '!=', null);
        })->get();

        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}
