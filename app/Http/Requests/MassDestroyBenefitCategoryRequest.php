<?php

namespace App\Http\Requests;

use App\Models\BenefitCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBenefitCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('benefit_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:benefit_categories,id',
        ];
    }
}
