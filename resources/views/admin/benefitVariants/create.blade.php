@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.benefitVariant.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.benefit-variants.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.benefitVariant.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitVariant.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.benefitVariant.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}">
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitVariant.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="credit_amount">{{ trans('cruds.benefitVariant.fields.credit_amount') }}</label>
                <input class="form-control {{ $errors->has('credit_amount') ? 'is-invalid' : '' }}" type="number" name="credit_amount" id="credit_amount" value="{{ old('credit_amount', '') }}" step="0.01">
                @if($errors->has('credit_amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('credit_amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitVariant.fields.credit_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="start_date">{{ trans('cruds.benefitVariant.fields.start_date') }}</label>
                <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text" name="start_date" id="start_date" value="{{ old('start_date') }}">
                @if($errors->has('start_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('start_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitVariant.fields.start_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="end_date">{{ trans('cruds.benefitVariant.fields.end_date') }}</label>
                <input class="form-control date {{ $errors->has('end_date') ? 'is-invalid' : '' }}" type="text" name="end_date" id="end_date" value="{{ old('end_date') }}">
                @if($errors->has('end_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('end_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitVariant.fields.end_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.benefitVariant.fields.satus') }}</label>
                @foreach(App\Models\BenefitVariant::SATUS_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('satus') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="satus_{{ $key }}" name="satus" value="{{ $key }}" {{ old('satus', 'Active') === (string) $key ? 'checked' : '' }} required>
                        <label class="form-check-label" for="satus_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('satus'))
                    <div class="invalid-feedback">
                        {{ $errors->first('satus') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitVariant.fields.satus_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="picture">{{ trans('cruds.benefitVariant.fields.picture') }}</label>
                <div class="needsclick dropzone {{ $errors->has('picture') ? 'is-invalid' : '' }}" id="picture-dropzone">
                </div>
                @if($errors->has('picture'))
                    <div class="invalid-feedback">
                        {{ $errors->first('picture') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitVariant.fields.picture_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="benefit_id">{{ trans('cruds.benefitVariant.fields.benefit') }}</label>
                <select class="form-control select2 {{ $errors->has('benefit') ? 'is-invalid' : '' }}" name="benefit_id" id="benefit_id">
                    @foreach($benefits as $id => $entry)
                        <option value="{{ $id }}" {{ old('benefit_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('benefit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('benefit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitVariant.fields.benefit_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.pictureDropzone = {
    url: '{{ route('admin.benefit-variants.storeMedia') }}',
    maxFilesize: 5, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="picture"]').remove()
      $('form').append('<input type="hidden" name="picture" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="picture"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($benefitVariant) && $benefitVariant->picture)
      var file = {!! json_encode($benefitVariant->picture) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="picture" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
@endsection