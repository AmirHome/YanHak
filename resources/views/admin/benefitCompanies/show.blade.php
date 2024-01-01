@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.benefitCompany.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.benefit-companies.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitCompany.fields.id') }}
                        </th>
                        <td>
                            {{ $benefitCompany->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitCompany.fields.name') }}
                        </th>
                        <td>
                            {{ $benefitCompany->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitCompany.fields.email') }}
                        </th>
                        <td>
                            {{ $benefitCompany->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitCompany.fields.web_site') }}
                        </th>
                        <td>
                            {{ $benefitCompany->web_site }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitCompany.fields.contact') }}
                        </th>
                        <td>
                            {{ $benefitCompany->contact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitCompany.fields.contact_email') }}
                        </th>
                        <td>
                            {{ $benefitCompany->contact_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitCompany.fields.phone') }}
                        </th>
                        <td>
                            {{ $benefitCompany->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitCompany.fields.register_date') }}
                        </th>
                        <td>
                            {{ $benefitCompany->register_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitCompany.fields.tax_number') }}
                        </th>
                        <td>
                            {{ $benefitCompany->tax_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitCompany.fields.tax_office') }}
                        </th>
                        <td>
                            {{ $benefitCompany->tax_office }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitCompany.fields.address') }}
                        </th>
                        <td>
                            {{ $benefitCompany->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitCompany.fields.city') }}
                        </th>
                        <td>
                            {{ $benefitCompany->city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitCompany.fields.country') }}
                        </th>
                        <td>
                            {{ $benefitCompany->country }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.benefit-companies.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#benefit_company_benefits" role="tab" data-toggle="tab">
                {{ trans('cruds.benefit.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="benefit_company_benefits">
            @includeIf('admin.benefitCompanies.relationships.benefitCompanyBenefits', ['benefits' => $benefitCompany->benefitCompanyBenefits])
        </div>
    </div>
</div>

@endsection