<?php

namespace App\Http\Controllers;

use App\constants\Roles;
use App\constants\Status;
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

    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor', 'service'])
            ->filterByStatus($request->status)
            ->filterByDate($request->date_from, $request->date_to)
            ->filterByDoctor($request->doctor_id);

        if (auth()->user()->role_id !== Roles::ADMIN) {
            // For non-admin users: filter appointments by patients under the user
            $query->whereHas('patient', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        // Apply sorting
        $sortField = $request->sort ?? 'appointment_date';
        $sortDirection = $request->direction ?? 'desc';

        $appointments = $query->orderBy($sortField, $sortDirection)
            ->paginate(15)
            ->appends($request->query());

        return Inertia::render('Appointments/Index', [
            'appointments' => $appointments,
            'doctors' => Doctor::all(),
            'filters' => $request->only(['status', 'date_from', 'date_to', 'doctor_id', 'sort', 'direction']),
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
            $data['status'] = Status::CONFIRMED;
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
        // For non-admin users, only show the patient that belongs to them
        $patients = auth()->user()->role_id === Roles::ADMIN
            ? Patient::all()
            : Patient::where('user_id', auth()->id())->get();

        return Inertia::render('Appointments/Edit', [
            'appointment' => $appointment->load(['patient', 'doctor', 'service']),
            'patients' => $patients,
            'doctors' => Doctor::all(),
            'services' => Service::all(),
        ]);
    }

    public function update(AppointmentRequest $request, Appointment $appointment)
    {
        $data = $request->validated();

        if (auth()->user()->role_id !== Roles::ADMIN) {
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
