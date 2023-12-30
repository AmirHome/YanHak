<?php

namespace App\Http\Requests;

use App\Models\BenefitCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBenefitCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('benefit_category_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
        ];
    }
}
