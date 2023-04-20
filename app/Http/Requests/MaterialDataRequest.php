<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'material_id'  => ['required'],
            'teacher_id'  => ['required'],
            'level_id'  => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'material_id.required' =>'ادخل  المبلغ من فضلك',
            'details.required' =>'ادخل  التفاصيل من فضلك',
            'amount.numeric' =>' المبلغ يجب عن يكون نصا ',
            'teacher_id.required' =>'حدد نوع المعاملة من فضلك',
            'level_id.required' =>'حدد طريق الاستلام  من فضلك',
        ];
    }
}
