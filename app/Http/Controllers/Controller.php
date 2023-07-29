<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    protected function checkUserAbility(?string $ability = null): void
    {
        if ($ability && auth()->user()?->cannot($ability)) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }
}
