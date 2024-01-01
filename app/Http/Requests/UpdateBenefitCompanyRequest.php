<?php

namespace App\Http\Requests;

use App\Models\BenefitCompany;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBenefitCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('benefit_company_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'web_site' => [
                'string',
                'nullable',
            ],
            'contact' => [
                'string',
                'nullable',
            ],
            'phone' => [
                'string',
                'min:10',
                'max:18',
                'nullable',
            ],
            'register_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'tax_number' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'tax_office' => [
                'string',
                'nullable',
            ],
            'address' => [
                'string',
                'nullable',
            ],
            'city' => [
                'string',
                'nullable',
            ],
            'country' => [
                'string',
                'nullable',
            ],
        ];
    }
}
