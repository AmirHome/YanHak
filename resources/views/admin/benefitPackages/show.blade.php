@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.benefitPackage.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.benefit-packages.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitPackage.fields.id') }}
                        </th>
                        <td>
                            {{ $benefitPackage->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitPackage.fields.title') }}
                        </th>
                        <td>
                            {{ $benefitPackage->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitPackage.fields.description') }}
                        </th>
                        <td>
                            {{ $benefitPackage->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitPackage.fields.picture') }}
                        </th>
                        <td>
                            @if($benefitPackage->picture)
                                <a href="{{ $benefitPackage->picture->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $benefitPackage->picture->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitPackage.fields.credit_amount') }}
                        </th>
                        <td>
                            {{ $benefitPackage->credit_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefitPackage.fields.benefit') }}
                        </th>
                        <td>
                            @foreach($benefitPackage->benefits as $key => $benefit)
                                <span class="label label-info">{{ $benefit->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.benefit-packages.index') }}">
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
            <a class="nav-link" href="#benefit_packages_employees" role="tab" data-toggle="tab">
                {{ trans('cruds.employee.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="benefit_packages_employees">
            @includeIf('admin.benefitPackages.relationships.benefitPackagesEmployees', ['employees' => $benefitPackage->benefitPackagesEmployees])
        </div>
    </div>
</div>

@endsection