<?php

namespace App\Http\Requests;

use App\Models\BenefitVariant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBenefitVariantRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('benefit_variant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:benefit_variants,id',
        ];
    }
}
