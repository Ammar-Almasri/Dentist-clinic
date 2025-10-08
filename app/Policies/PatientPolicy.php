<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;
use App\constants\Roles; // make sure this is the correct path

class PatientPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Patient $patient): bool
    {
        return $user->role_id === Roles::ADMIN || $user->id === $patient->user_id || $user->role_id === Roles::SUPER_ADMIN;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Patient $patient): bool
    {
        return $user->role_id === Roles::ADMIN || $user->id === $patient->user_id || $user->role_id === Roles::SUPER_ADMIN;
    }

    public function delete(User $user, Patient $patient): bool
    {
        return $user->role_id === Roles::ADMIN || $user->id === $patient->user_id || $user->role_id === Roles::SUPER_ADMIN;
    }

    public function restore(User $user, Patient $patient): bool
    {
        return $user->role_id === Roles::ADMIN || $user->role_id === Roles::SUPER_ADMIN;
    }

    public function forceDelete(User $user, Patient $patient): bool
    {
        return $user->role_id === Roles::ADMIN || $user->role_id === Roles::SUPER_ADMIN;
    }
}
