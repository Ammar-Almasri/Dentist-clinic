<?php

namespace App\Http\Controllers;

use App\Constants\Roles;
use App\Http\Requests\PatientRequest;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Patient::class, 'patient');
    }

    public function index()
    {
        $user = Auth::user();

        $patients = $user->role_id === Roles::ADMIN
            ? Patient::all()
            : Patient::where('user_id', $user->id)->get();

        return Inertia::render('Patients/Index', [
            'patients' => $patients,
        ]);
    }

    public function create()
    {
        return Inertia::render('Patients/Create');
    }

    public function store(PatientRequest $request)
    {
        $data = $request->validated();

        if (Auth::user()->role_id === Roles::ADMIN) {
            // Admin: check if there's a user with same phone and assign user_id
            $user = \App\Models\User::where('phone', $data['phone'])->first();
            if ($user) {
                $data['user_id'] = $user->id;
            }
        } else {
            // Non-admin: always assign current user's ID
            $data['user_id'] = Auth::id();
            $data['phone'] = Auth::user()->phone; // Use current user's phone
        }

        Patient::create($data);

        return redirect()->route('patients.index')->with('success', 'Patient created.');
    }

    public function show(Patient $patient)
    {
        return Inertia::render('Patients/Show', [
            'patient' => $patient,
        ]);
    }

    public function edit(Patient $patient)
    {
        return Inertia::render('Patients/Edit', [
            'patient' => $patient,
        ]);
    }

    public function update(PatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated());

        return redirect()->route('patients.index')->with('success', 'Patient updated.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient deleted.');
    }
}
