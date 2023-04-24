<?php
declare(strict_types=1);

namespace App\Service;

use Illuminate\Support\Str;

class SomeOtherService
{
    public function getUserPassword()
    {
        return Str::password();
    }
}
