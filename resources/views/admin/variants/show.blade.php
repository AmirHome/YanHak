@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.variant.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.variants.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.variant.fields.id') }}
                        </th>
                        <td>
                            {{ $variant->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.variant.fields.name') }}
                        </th>
                        <td>
                            {{ $variant->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.variant.fields.description') }}
                        </th>
                        <td>
                            {{ $variant->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.variant.fields.credit_amount') }}
                        </th>
                        <td>
                            {{ $variant->credit_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.variant.fields.start_date') }}
                        </th>
                        <td>
                            {{ $variant->start_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.variant.fields.end_date') }}
                        </th>
                        <td>
                            {{ $variant->end_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.variant.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Variant::STATUS_SELECT[$variant->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.variant.fields.benefit') }}
                        </th>
                        <td>
                            {{ $variant->benefit->title ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.variants.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection