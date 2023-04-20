<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('student_create');
    }
    public function rules()
    {
        return [
            'details' => ['nullable', 'string', 'max:255'],
            'phone'  => ['required', 'string'],
            'name'  => ['required', 'string'],
            'age'  => ['nullable'],
            'level_id'  => ['integer', 'required', 'exists:levels,id',]
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
