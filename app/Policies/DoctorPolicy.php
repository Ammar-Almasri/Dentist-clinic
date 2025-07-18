<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\User;
use App\constants\Roles; // adjust the path if needed

class DoctorPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Doctor $doctor): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role_id === Roles::ADMIN;
    }

    public function update(User $user, Doctor $doctor): bool
    {
        return $user->role_id === Roles::ADMIN || $user->id === $doctor->user_id;
    }

    public function delete(User $user, Doctor $doctor): bool
    {
        return $user->role_id === Roles::ADMIN || $user->id === $doctor->user_id;
    }

    public function restore(User $user, Doctor $doctor): bool
    {
        return $user->role_id === Roles::ADMIN;
    }

    public function forceDelete(User $user, Doctor $doctor): bool
    {
        return $user->role_id === Roles::ADMIN;
    }
}
