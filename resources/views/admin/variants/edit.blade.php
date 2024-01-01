@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.variant.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.variants.update", [$variant->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.variant.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $variant->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.variant.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.variant.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $variant->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.variant.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="credit_amount">{{ trans('cruds.variant.fields.credit_amount') }}</label>
                <input class="form-control {{ $errors->has('credit_amount') ? 'is-invalid' : '' }}" type="number" name="credit_amount" id="credit_amount" value="{{ old('credit_amount', $variant->credit_amount) }}" step="0.01" required>
                @if($errors->has('credit_amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('credit_amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.variant.fields.credit_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="start_date">{{ trans('cruds.variant.fields.start_date') }}</label>
                <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text" name="start_date" id="start_date" value="{{ old('start_date', $variant->start_date) }}">
                @if($errors->has('start_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('start_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.variant.fields.start_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="end_date">{{ trans('cruds.variant.fields.end_date') }}</label>
                <input class="form-control date {{ $errors->has('end_date') ? 'is-invalid' : '' }}" type="text" name="end_date" id="end_date" value="{{ old('end_date', $variant->end_date) }}">
                @if($errors->has('end_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('end_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.variant.fields.end_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.variant.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Variant::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $variant->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.variant.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="benefit_id">{{ trans('cruds.variant.fields.benefit') }}</label>
                <select class="form-control select2 {{ $errors->has('benefit') ? 'is-invalid' : '' }}" name="benefit_id" id="benefit_id" required>
                    @foreach($benefits as $id => $entry)
                        <option value="{{ $id }}" {{ (old('benefit_id') ? old('benefit_id') : $variant->benefit->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('benefit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('benefit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.variant.fields.benefit_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection