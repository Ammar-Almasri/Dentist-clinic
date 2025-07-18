<?php

namespace App\Http\Controllers;

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
        $patients = Patient::all();

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
        Patient::create($request->validated());

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
    public function userIndex()
    {
        $patients = Patient::where('user_id', Auth::id())->get();

        return Inertia::render('Patients/Index', [
            'patients' => $patients,
        ]);
    }

    public function userCreate()
    {
        return Inertia::render('Patients/Create');
    }

    public function userStore(PatientRequest $request)
    {
        Patient::create([
            ...$request->validated(),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('patients.userIndex')->with('success', 'Patient created.');
    }

    public function userEdit(Patient $patient)
    {
        $this->authorize('view', $patient); // reuse view policy to check ownership

        return Inertia::render('Patients/Edit', [
            'patient' => $patient,
        ]);
    }

    public function userUpdate(PatientRequest $request, Patient $patient)
    {
        $this->authorize('update', $patient); // you can change this to update if you allow it later

        $patient->update($request->validated());

        return redirect()->route('patients.userIndex')->with('success', 'Patient updated.');
    }

    public function userDestroy(Patient $patient)
    {
        $this->authorize('delete', $patient); // same, use policy

        $patient->delete();

        return redirect()->route('patients.userIndex')->with('success', 'Patient deleted.');
    }

}
