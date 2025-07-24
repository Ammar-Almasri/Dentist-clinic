<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Doctor;
use App\Policies\DoctorPolicy;
use App\Models\Patient;
use App\Policies\PatientPolicy;
use App\Models\Appointment;
use App\Policies\AppointmentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Doctor::class => DoctorPolicy::class,
        Patient::class => PatientPolicy::class,
        Appointment::class => AppointmentPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
