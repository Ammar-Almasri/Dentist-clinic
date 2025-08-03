<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorRequest;
use App\Models\Doctor;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Pagination\LengthAwarePaginator;

class DoctorController extends Controller
{
    public function __construct()
    {
        // This connects your resource methods to DoctorPolicy automatically
        $this->authorizeResource(Doctor::class, 'doctor');
    }


    public function index(Request $request)
    {
        $perPage = 4;

        $doctors = Doctor::query()
            ->filterByName($request->name)
            ->filterBySpeciality($request->speciality)
            ->filterByPhone($request->phone)
            ->paginate($perPage)
            ->appends($request->only(['name', 'speciality', 'phone']));

        $doctors->getCollection()->transform(function ($doctor) {
            $photoPath = "photos/{$doctor->name}.jpg";

            $doctor->photo_url = file_exists(public_path($photoPath))
                ? asset($photoPath)
                : null;

            return $doctor;
        });

        return Inertia::render('Doctors/Index', [
            'doctors' => $doctors,
            'auth' => ['user' => Auth::user()],
            'filters' => $request->only(['name', 'speciality', 'phone']),
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
        $doctor->load('services'); // load services relation

        $photoPath = "photos/{$doctor->name}.jpg";

        $doctor->photo_url = file_exists(public_path($photoPath))
            ? asset($photoPath)
            : null;

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
