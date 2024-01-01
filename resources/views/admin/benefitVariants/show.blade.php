@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.benefitVariant.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.benefit-variants.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitVariant.fields.id') }}
                        </th>
                        <td>
                            {{ $benefitVariant->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitVariant.fields.picture') }}
                        </th>
                        <td>
                            @if($benefitVariant->picture)
                                <a href="{{ $benefitVariant->picture->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $benefitVariant->picture->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitVariant.fields.name') }}
                        </th>
                        <td>
                            {{ $benefitVariant->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitVariant.fields.benefit') }}
                        </th>
                        <td>
                            {{ $benefitVariant->benefit->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitVariant.fields.description') }}
                        </th>
                        <td>
                            {{ $benefitVariant->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitVariant.fields.credit_amount') }}
                        </th>
                        <td>
                            {{ $benefitVariant->credit_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitVariant.fields.start_date') }}
                        </th>
                        <td>
                            {{ $benefitVariant->start_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitVariant.fields.end_date') }}
                        </th>
                        <td>
                            {{ $benefitVariant->end_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitVariant.fields.satus') }}
                        </th>
                        <td>
                            {{ App\Models\BenefitVariant::SATUS_RADIO[$benefitVariant->satus] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.benefit-variants.index') }}">
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
            <a class="nav-link" href="#variant_benefits" role="tab" data-toggle="tab">
                {{ trans('cruds.benefit.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#benfitvariant_employees" role="tab" data-toggle="tab">
                {{ trans('cruds.employee.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#benefit_benefit_packages" role="tab" data-toggle="tab">
                {{ trans('cruds.benefitPackage.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="variant_benefits">
            @includeIf('admin.benefitVariants.relationships.variantBenefits', ['benefits' => $benefitVariant->variantBenefits])
        </div>
        <div class="tab-pane" role="tabpanel" id="benfitvariant_employees">
            @includeIf('admin.benefitVariants.relationships.benfitvariantEmployees', ['employees' => $benefitVariant->benfitvariantEmployees])
        </div>
        <div class="tab-pane" role="tabpanel" id="benefit_benefit_packages">
            @includeIf('admin.benefitVariants.relationships.benefitBenefitPackages', ['benefitPackages' => $benefitVariant->benefitBenefitPackages])
        </div>
    </div>
</div>

@endsection