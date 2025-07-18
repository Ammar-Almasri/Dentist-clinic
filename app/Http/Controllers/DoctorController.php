<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorRequest;
use App\Models\Doctor;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class DoctorController extends Controller
{
    public function __construct()
    {
        // This connects your resource methods to DoctorPolicy automatically
        $this->authorizeResource(Doctor::class, 'doctor');
    }

    public function index()
    {
        $doctors = Doctor::all();

        return Inertia::render('Doctors/Index', [
            'doctors' => $doctors,
        ]);
    }

    public function create()
    {
        return Inertia::render('Doctors/Create');
    }

    public function store(DoctorRequest $request)
    {
        Doctor::create($request->validated());

        return redirect()->route('doctors.index')->with('success', 'Doctor created.');
    }

    public function show(Doctor $doctor)
    {
        return Inertia::render('Doctors/Show', [
            'doctor' => $doctor,
        ]);
    }

    public function edit(Doctor $doctor)
    {
        return Inertia::render('Doctors/Edit', [
            'doctor' => $doctor,
        ]);
    }

    public function update(DoctorRequest $request, Doctor $doctor)
    {
        $doctor->update($request->validated());

        return redirect()->route('doctors.index')->with('success', 'Doctor updated.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctor deleted.');
    }
}
