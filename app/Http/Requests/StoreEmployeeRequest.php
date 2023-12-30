<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_create');
    }

    public function rules()
    {
        return [
            'identity' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'birthday' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'mobile' => [
                'string',
                'nullable',
            ],
            'name' => [
                'string',
                'required',
            ],
            'family' => [
                'string',
                'required',
            ],
            'job_title' => [
                'string',
                'nullable',
            ],
            'department' => [
                'string',
                'nullable',
            ],
            'email' => [
                'string',
                'nullable',
            ],
            'phone' => [
                'string',
                'nullable',
            ],
            'benefits.*' => [
                'integer',
            ],
            'benefits' => [
                'required',
                'array',
            ],
        ];
    }
}
