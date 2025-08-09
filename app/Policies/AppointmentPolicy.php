<?php

namespace App\Policies;

use App\constants\Roles;
use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    /**
     * Determine whether the user can view any appointments.
     */
    public function viewAny(User $user): bool
    {
        // Admin and patient can view appointments (you can adjust)
        return in_array($user->role_id, [Roles::ADMIN, Roles::PATIENT]);
    }

    /**
     * Determine whether the user can view the appointment.
     */
    public function view(User $user, Appointment $appointment): bool
    {
        if ($user->role_id === Roles::ADMIN) {
            return true; // Admin can view all
        }

        if ($user->role_id === Roles::PATIENT) {
            // Patient can view only if appointment belongs to one of their patients
            return $appointment->patient->user_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create appointments.
     */
    public function create(User $user): bool
    {
        // Admin and patient can create
        return in_array($user->role_id, [Roles::ADMIN, Roles::PATIENT]);
    }

    /**
     * Determine whether the user can update the appointment.
     */
    public function update(User $user, Appointment $appointment): bool
    {
        if ($user->role_id === Roles::ADMIN) {
            return true;
        }

        if ($user->role_id === Roles::PATIENT) {
            return $appointment->patient->user_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the appointment.
     */
    public function delete(User $user, Appointment $appointment): bool
    {
        if ($user->role_id === Roles::ADMIN) {
            return true;
        }

        if ($user->role_id === Roles::PATIENT) {
            return $appointment->patient->user_id === $user->id;
        }

        return false;
    }
}
