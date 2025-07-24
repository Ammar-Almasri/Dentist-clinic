<?php

namespace App\Http\Requests;

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
            'appointment_date' => 'required|date|after_or_equal:today',
            'status' => 'in:0,1',
        ];
    }
}
