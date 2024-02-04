<?php

namespace App\Rules;

use App\Models\User;
use App\Models\UserRoles;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

readonly class Role implements ValidationRule
{
    public function __construct(private array $roles)
    {}

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var User $user */
        $user = User::query()->with('roles')->find($value, ['id']);

        if ($user && !$user->hasAnyRole(collect($this->roles)->map(fn (UserRoles $role) => $role->value)->toArray())) {
            $fail(match ($attribute) {
                'client' => ucfirst($attribute) . ' does not have an appropriate role.',
                'assigned_to' => 'User you are assigning to does not have an appropriate role.',
                default => 'User does not have an appropriate role.'
            });
        }
    }
}
