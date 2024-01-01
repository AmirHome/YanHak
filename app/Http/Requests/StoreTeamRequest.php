<?php

namespace App\Http\Requests;

use App\Models\Team;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTeamRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('team_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'tax_office' => [
                'string',
                'nullable',
            ],
            'tax_number' => [
                'string',
                'nullable',
            ],
            'web_site' => [
                'string',
                'nullable',
            ],
            'primary_contact' => [
                'string',
                'nullable',
            ],
            'telephone' => [
                'string',
                'min:10',
                'max:15',
                'nullable',
            ],
            'address' => [
                'string',
                'nullable',
            ],
            'zip_code' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
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
