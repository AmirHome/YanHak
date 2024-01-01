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
                            {{ trans('cruds.benefit.fields.name') }}
                        </th>
                        <td>
                            {{ $benefit->name }}
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
                            {{ trans('cruds.benefit.fields.category') }}
                        </th>
                        <td>
                            {{ $benefit->category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefit.fields.benefit_company') }}
                        </th>
                        <td>
                            {{ $benefit->benefit_company->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefit.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Benefit::STATUS_RADIO[$benefit->status] ?? '' }}
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
                            {{ trans('cruds.benefit.fields.start_date') }}
                        </th>
                        <td>
                            {{ $benefit->start_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefit.fields.variant') }}
                        </th>
                        <td>
                            @foreach($benefit->variants as $key => $variant)
                                <span class="label label-info">{{ $variant->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefit.fields.end_date') }}
                        </th>
                        <td>
                            {{ $benefit->end_date }}
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
            <a class="nav-link" href="#benefit_benefit_variants" role="tab" data-toggle="tab">
                {{ trans('cruds.benefitVariant.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="benefit_benefit_variants">
            @includeIf('admin.benefits.relationships.benefitBenefitVariants', ['benefitVariants' => $benefit->benefitBenefitVariants])
        </div>
    </div>
</div>

@endsection