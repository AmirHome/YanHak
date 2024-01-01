@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.employee.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employees.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="picture">{{ trans('cruds.employee.fields.picture') }}</label>
                <div class="needsclick dropzone {{ $errors->has('picture') ? 'is-invalid' : '' }}" id="picture-dropzone">
                </div>
                @if($errors->has('picture'))
                    <div class="invalid-feedback">
                        {{ $errors->first('picture') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.picture_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.employee.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="sur_name">{{ trans('cruds.employee.fields.sur_name') }}</label>
                <input class="form-control {{ $errors->has('sur_name') ? 'is-invalid' : '' }}" type="text" name="sur_name" id="sur_name" value="{{ old('sur_name', '') }}" required>
                @if($errors->has('sur_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sur_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.sur_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="personel">{{ trans('cruds.employee.fields.personel') }}</label>
                <input class="form-control {{ $errors->has('personel') ? 'is-invalid' : '' }}" type="text" name="personel" id="personel" value="{{ old('personel', '') }}">
                @if($errors->has('personel'))
                    <div class="invalid-feedback">
                        {{ $errors->first('personel') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.personel_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="identity_number">{{ trans('cruds.employee.fields.identity_number') }}</label>
                <input class="form-control {{ $errors->has('identity_number') ? 'is-invalid' : '' }}" type="text" name="identity_number" id="identity_number" value="{{ old('identity_number', '') }}">
                @if($errors->has('identity_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('identity_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.identity_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.employee.fields.working_type') }}</label>
                <select class="form-control {{ $errors->has('working_type') ? 'is-invalid' : '' }}" name="working_type" id="working_type">
                    <option value disabled {{ old('working_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::WORKING_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('working_type', 'FullTime') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('working_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('working_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.working_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="job_title">{{ trans('cruds.employee.fields.job_title') }}</label>
                <input class="form-control {{ $errors->has('job_title') ? 'is-invalid' : '' }}" type="text" name="job_title" id="job_title" value="{{ old('job_title', '') }}">
                @if($errors->has('job_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('job_title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.job_title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="department">{{ trans('cruds.employee.fields.department') }}</label>
                <input class="form-control {{ $errors->has('department') ? 'is-invalid' : '' }}" type="text" name="department" id="department" value="{{ old('department', '') }}">
                @if($errors->has('department'))
                    <div class="invalid-feedback">
                        {{ $errors->first('department') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.department_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="yearly_credit">{{ trans('cruds.employee.fields.yearly_credit') }}</label>
                <input class="form-control {{ $errors->has('yearly_credit') ? 'is-invalid' : '' }}" type="number" name="yearly_credit" id="yearly_credit" value="{{ old('yearly_credit', '') }}" step="0.01">
                @if($errors->has('yearly_credit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('yearly_credit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.yearly_credit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="mobile_phone">{{ trans('cruds.employee.fields.mobile_phone') }}</label>
                <input class="form-control {{ $errors->has('mobile_phone') ? 'is-invalid' : '' }}" type="text" name="mobile_phone" id="mobile_phone" value="{{ old('mobile_phone', '') }}">
                @if($errors->has('mobile_phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mobile_phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.mobile_phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.employee.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.employee.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="birthday">{{ trans('cruds.employee.fields.birthday') }}</label>
                <input class="form-control date {{ $errors->has('birthday') ? 'is-invalid' : '' }}" type="text" name="birthday" id="birthday" value="{{ old('birthday') }}">
                @if($errors->has('birthday'))
                    <div class="invalid-feedback">
                        {{ $errors->first('birthday') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.birthday_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.employee.fields.gender') }}</label>
                <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender">
                    <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::GENDER_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('gender', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('gender'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gender') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.gender_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.employee.fields.status') }}</label>
                @foreach(App\Models\Employee::STATUS_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', 'Active') === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="benfitvariants">{{ trans('cruds.employee.fields.benfitvariant') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('benfitvariants') ? 'is-invalid' : '' }}" name="benfitvariants[]" id="benfitvariants" multiple>
                    @foreach($benfitvariants as $id => $benfitvariant)
                        <option value="{{ $id }}" {{ in_array($id, old('benfitvariants', [])) ? 'selected' : '' }}>{{ $benfitvariant }}</option>
                    @endforeach
                </select>
                @if($errors->has('benfitvariants'))
                    <div class="invalid-feedback">
                        {{ $errors->first('benfitvariants') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.benfitvariant_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="benefit_packages">{{ trans('cruds.employee.fields.benefit_packages') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('benefit_packages') ? 'is-invalid' : '' }}" name="benefit_packages[]" id="benefit_packages" multiple>
                    @foreach($benefit_packages as $id => $benefit_package)
                        <option value="{{ $id }}" {{ in_array($id, old('benefit_packages', [])) ? 'selected' : '' }}>{{ $benefit_package }}</option>
                    @endforeach
                </select>
                @if($errors->has('benefit_packages'))
                    <div class="invalid-feedback">
                        {{ $errors->first('benefit_packages') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.benefit_packages_helper') }}</span>
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
    url: '{{ route('admin.employees.storeMedia') }}',
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
@if(isset($employee) && $employee->picture)
      var file = {!! json_encode($employee->picture) !!}
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