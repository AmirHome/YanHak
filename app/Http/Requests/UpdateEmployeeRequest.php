<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'sur_name' => [
                'string',
                'required',
            ],
            'personel' => [
                'string',
                'nullable',
            ],
            'identity_number' => [
                'string',
                'nullable',
            ],
            'job_title' => [
                'string',
                'nullable',
            ],
            'department' => [
                'string',
                'nullable',
            ],
            'mobile_phone' => [
                'string',
                'min:8',
                'max:15',
                'nullable',
            ],
            'phone' => [
                'string',
                'min:10',
                'max:17',
                'nullable',
            ],
            'birthday' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'benfitvariants.*' => [
                'integer',
            ],
            'benfitvariants' => [
                'array',
            ],
            'benefit_packages.*' => [
                'integer',
            ],
            'benefit_packages' => [
                'array',
            ],
        ];
    }
}
