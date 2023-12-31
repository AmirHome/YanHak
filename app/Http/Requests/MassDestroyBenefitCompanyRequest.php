<?php

namespace App\Http\Requests;

use App\Models\BenefitCompany;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBenefitCompanyRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('benefit_company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:benefit_companies,id',
        ];
    }
}
