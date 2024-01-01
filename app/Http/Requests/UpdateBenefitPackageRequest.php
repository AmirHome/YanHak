<?php

namespace App\Http\Requests;

use App\Models\BenefitPackage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBenefitPackageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('benefit_package_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'description' => [
                'string',
                'nullable',
            ],
            'benefits.*' => [
                'integer',
            ],
            'benefits' => [
                'array',
            ],
        ];
    }
}
