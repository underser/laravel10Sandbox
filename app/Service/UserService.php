<?php
declare(strict_types=1);

namespace App\Service;

class UserService
{
    public function __construct(private SomeOtherService $someOtherService)
    {
    }

    public function getUsersList(): array
    {
        return [
            'John Doe' => $this->someOtherService->getUserPassword(),
            'John Lewis' => $this->someOtherService->getUserPassword(),
        ];
    }
}
