@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.benefit.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.benefits.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.benefit.fields.id') }}
                        </th>
                        <td>
                            {{ $benefit->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefit.fields.title') }}
                        </th>
                        <td>
                            {{ $benefit->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefit.fields.description') }}
                        </th>
                        <td>
                            {{ $benefit->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefit.fields.credit_amount') }}
                        </th>
                        <td>
                            {{ $benefit->credit_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefit.fields.picture') }}
                        </th>
                        <td>
                            @if($benefit->picture)
                                <a href="{{ $benefit->picture->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $benefit->picture->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefit.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Benefit::STATUS_SELECT[$benefit->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefit.fields.start') }}
                        </th>
                        <td>
                            {{ $benefit->start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefit.fields.end') }}
                        </th>
                        <td>
                            {{ $benefit->end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefit.fields.category') }}
                        </th>
                        <td>
                            {{ $benefit->category->title ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.benefits.index') }}">
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
            <a class="nav-link" href="#benefit_employees" role="tab" data-toggle="tab">
                {{ trans('cruds.employee.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="benefit_employees">
            @includeIf('admin.benefits.relationships.benefitEmployees', ['employees' => $benefit->benefitEmployees])
        </div>
    </div>
</div>

@endsection