<?php
declare(strict_types=1);

namespace App\Models;

enum UserRoles: string
{
    case ADMINISTRATOR = 'Administrator';
    case CLIENT = 'Client';
    case PROJECT_MANAGER = 'Project manager';
    case USER = 'User';
}
