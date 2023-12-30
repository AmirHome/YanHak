<?php

namespace App\Http\Requests;

use App\Models\BenefitCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBenefitCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('benefit_category_edit');
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
