<?php

use App\Models\User;
use App\Models\SupportStaff;

function isValidForGuardedType($user, string $type, int $id): bool
{
    if ($type === 'user' && $user instanceof User) {
        return $user->id == $id;
    }

    if ($type === 'support' && $user instanceof SupportStaff) {
        return $user->id == $id;
    }

    return false;
}
