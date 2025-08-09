<?php

namespace App\Http\Controllers;

use App\constants\Roles;
use App\Http\Requests\PatientRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Patient::class, 'patient');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Patient::query()
            ->filterByName($request->name)
            ->filterByPhone($request->phone);

        if ($user->role_id !== Roles::ADMIN) {
            $query->where('user_id', $user->id);
        }

        $patients = $query->paginate(4)->withQueryString();

        return Inertia::render('Patients/Index', [
            'patients' => $patients,
            'filters' => $request->only(['name', 'phone']),
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
            $user = User::where('phone', $data['phone'])->first();
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
