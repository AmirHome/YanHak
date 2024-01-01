@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.team.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.teams.update", [$team->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.team.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $team->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.team.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="logo">{{ trans('cruds.team.fields.logo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('logo') ? 'is-invalid' : '' }}" id="logo-dropzone">
                </div>
                @if($errors->has('logo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('logo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.team.fields.logo_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tax_office">{{ trans('cruds.team.fields.tax_office') }}</label>
                <input class="form-control {{ $errors->has('tax_office') ? 'is-invalid' : '' }}" type="text" name="tax_office" id="tax_office" value="{{ old('tax_office', $team->tax_office) }}">
                @if($errors->has('tax_office'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tax_office') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.team.fields.tax_office_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tax_number">{{ trans('cruds.team.fields.tax_number') }}</label>
                <input class="form-control {{ $errors->has('tax_number') ? 'is-invalid' : '' }}" type="text" name="tax_number" id="tax_number" value="{{ old('tax_number', $team->tax_number) }}">
                @if($errors->has('tax_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tax_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.team.fields.tax_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="web_site">{{ trans('cruds.team.fields.web_site') }}</label>
                <input class="form-control {{ $errors->has('web_site') ? 'is-invalid' : '' }}" type="text" name="web_site" id="web_site" value="{{ old('web_site', $team->web_site) }}">
                @if($errors->has('web_site'))
                    <div class="invalid-feedback">
                        {{ $errors->first('web_site') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.team.fields.web_site_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="primary_contact">{{ trans('cruds.team.fields.primary_contact') }}</label>
                <input class="form-control {{ $errors->has('primary_contact') ? 'is-invalid' : '' }}" type="text" name="primary_contact" id="primary_contact" value="{{ old('primary_contact', $team->primary_contact) }}">
                @if($errors->has('primary_contact'))
                    <div class="invalid-feedback">
                        {{ $errors->first('primary_contact') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.team.fields.primary_contact_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact_email">{{ trans('cruds.team.fields.contact_email') }}</label>
                <input class="form-control {{ $errors->has('contact_email') ? 'is-invalid' : '' }}" type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $team->contact_email) }}">
                @if($errors->has('contact_email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('contact_email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.team.fields.contact_email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="telephone">{{ trans('cruds.team.fields.telephone') }}</label>
                <input class="form-control {{ $errors->has('telephone') ? 'is-invalid' : '' }}" type="text" name="telephone" id="telephone" value="{{ old('telephone', $team->telephone) }}">
                @if($errors->has('telephone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('telephone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.team.fields.telephone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.team.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $team->email) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.team.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.team.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $team->address) }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.team.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="zip_code">{{ trans('cruds.team.fields.zip_code') }}</label>
                <input class="form-control {{ $errors->has('zip_code') ? 'is-invalid' : '' }}" type="number" name="zip_code" id="zip_code" value="{{ old('zip_code', $team->zip_code) }}" step="1">
                @if($errors->has('zip_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('zip_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.team.fields.zip_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city">{{ trans('cruds.team.fields.city') }}</label>
                <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', $team->city) }}">
                @if($errors->has('city'))
                    <div class="invalid-feedback">
                        {{ $errors->first('city') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.team.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="country">{{ trans('cruds.team.fields.country') }}</label>
                <input class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" type="text" name="country" id="country" value="{{ old('country', $team->country) }}">
                @if($errors->has('country'))
                    <div class="invalid-feedback">
                        {{ $errors->first('country') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.team.fields.country_helper') }}</span>
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
    Dropzone.options.logoDropzone = {
    url: '{{ route('admin.teams.storeMedia') }}',
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
      $('form').find('input[name="logo"]').remove()
      $('form').append('<input type="hidden" name="logo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="logo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($team) && $team->logo)
      var file = {!! json_encode($team->logo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="logo" value="' + file.file_name + '">')
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