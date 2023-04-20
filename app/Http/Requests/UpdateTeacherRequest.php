<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('teacher_edit');
    }
    public function rules()
    {
        return [
            'details' => ['nullable', 'string', 'max:255'],
            'phone'  => ['required', 'string'],
            'name'  => ['required', 'string'],
            'address'  => ['nullable'],
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
