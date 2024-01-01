<?php

namespace App\Http\Requests;

use App\Models\BenefitPackage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBenefitPackageRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('benefit_package_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:benefit_packages,id',
        ];
    }
}
