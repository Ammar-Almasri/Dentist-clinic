<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Doctor;
use App\Policies\DoctorPolicy;
use App\Models\Patient;
use App\Policies\PatientPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Doctor::class => DoctorPolicy::class,
        Patient::class => PatientPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
