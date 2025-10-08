<?php

namespace App\Http\Requests;

use App\constants\Status;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // change if you need auth later
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'service_id' => 'nullable|exists:services,id',
            'appointment_date' => 'required|date_format:Y-m-d H:i:s|after_or_equal:now',
            'status' => 'nullable|in:' . implode(',', [Status::PENDING, Status::CONFIRMED]),
        ];
    }
}
