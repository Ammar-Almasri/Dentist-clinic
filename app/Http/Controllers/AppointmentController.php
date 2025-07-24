<?php

namespace App\Http\Controllers;

use App\Constants\Roles;
use App\Constants\Status;
use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Service;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Appointment::class, 'appointment');
    }

    public function index()
    {
        $query = Appointment::with(['patient', 'doctor', 'service']);

        if (auth()->user()->role_id !== Roles::ADMIN) {
            // For patient role: filter appointments by patients under the user
            $query->whereHas('patient', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        $appointments = $query->paginate(15);

        return Inertia::render('Appointments/Index', [
            'appointments' => $appointments,
        ]);
    }


    public function create()
    {
        $patients = Patient::forCurrentUser()->get();
        $doctors = Doctor::all();
        $services = Service::all();

        return Inertia::render('Appointments/Create', [
            'patients' => $patients,
            'doctors' => $doctors,
            'services' => $services,
        ]);
    }

    public function store(AppointmentRequest $request)
    {
        $data = $request->validated();

        if (auth()->user()->role_id === Roles::ADMIN) {
            $data['status'] = Status::BOOKED;
        } else {
            $data['status'] = Status::PENDING;
        }

        Appointment::create($data);

        return redirect()->route('appointments.index')->with('success', 'Appointment created.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'service']);

        return Inertia::render('Appointments/Show', [
            'appointment' => $appointment,
        ]);
    }

    public function edit(Appointment $appointment)
    {
        $patients = auth()->user()->role_id === Roles::ADMIN ? Patient::all() : null;
        $doctors = Doctor::all();
        $services = Service::all();

        return Inertia::render('Appointments/Edit', [
            'appointment' => $appointment,
            'patients' => $patients,
            'doctors' => $doctors,
            'services' => $services,
        ]);
    }

    public function update(AppointmentRequest $request, Appointment $appointment)
    {
        $data = $request->validated();

        if (auth()->user()->role_id === Roles::ADMIN) {
            $data['status'] = Status::BOOKED;
        } else {
            $data['status'] = Status::PENDING;
        }

        $appointment->update($data);

        return redirect()->route('appointments.index')->with('success', 'Appointment updated.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment deleted.');
    }
}
