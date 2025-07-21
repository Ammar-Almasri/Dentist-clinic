<?php

namespace App\Http\Requests;

use App\Constants\Roles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PatientRequest extends FormRequest
{
    public function authorize()
    {
        return true; // allow all users, adjust if needed
    }

    public function rules()
    {
        if (Auth::user()->role_id === Roles::ADMIN) {
            return [
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'birth_date' => 'required|date',
            ];
        }
        else {
            // For normal user, no need to validate phone or name because you override them
            return [
                'name' => 'required|string|max:255',
                'birth_date' => 'required|date',
                // phone is not required here because you assign it from Auth user
            ];
        }
    }
}
