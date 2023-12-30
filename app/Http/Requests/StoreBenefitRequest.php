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
            'title' => [
                'string',
                'required',
            ],
            'start' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'end' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'category_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
