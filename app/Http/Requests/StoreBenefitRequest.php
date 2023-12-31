<?php

namespace App\Http\Requests;

use App\Models\Benefit;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBenefitRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('benefit_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'description' => [
                'string',
                'nullable',
            ],
            'category_id' => [
                'required',
                'integer',
            ],
            'benefit_company_id' => [
                'required',
                'integer',
            ],
            'status' => [
                'required',
            ],
            'start_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'end_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
