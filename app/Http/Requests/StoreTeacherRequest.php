<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('teacher_create');
    }
    public function rules()
    {
        return [
            'details' => ['nullable', 'string', 'max:255'],
            'phone'  => ['required', 'string'],
            'name'  => ['required', 'string'],
            'address'  => ['nullable'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'details.string' => 'ادخل  التفاصيل من فضلك',
            'name.required' => 'ادخل اسم الطالب من فضلك',
        ];
    }
}
