@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.benefitCompany.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.benefit-companies.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.benefitCompany.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitCompany.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.benefitCompany.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitCompany.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="web_site">{{ trans('cruds.benefitCompany.fields.web_site') }}</label>
                <input class="form-control {{ $errors->has('web_site') ? 'is-invalid' : '' }}" type="text" name="web_site" id="web_site" value="{{ old('web_site', '') }}">
                @if($errors->has('web_site'))
                    <div class="invalid-feedback">
                        {{ $errors->first('web_site') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitCompany.fields.web_site_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact">{{ trans('cruds.benefitCompany.fields.contact') }}</label>
                <input class="form-control {{ $errors->has('contact') ? 'is-invalid' : '' }}" type="text" name="contact" id="contact" value="{{ old('contact', '') }}">
                @if($errors->has('contact'))
                    <div class="invalid-feedback">
                        {{ $errors->first('contact') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitCompany.fields.contact_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact_email">{{ trans('cruds.benefitCompany.fields.contact_email') }}</label>
                <input class="form-control {{ $errors->has('contact_email') ? 'is-invalid' : '' }}" type="email" name="contact_email" id="contact_email" value="{{ old('contact_email') }}">
                @if($errors->has('contact_email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('contact_email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitCompany.fields.contact_email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.benefitCompany.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitCompany.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="register_date">{{ trans('cruds.benefitCompany.fields.register_date') }}</label>
                <input class="form-control date {{ $errors->has('register_date') ? 'is-invalid' : '' }}" type="text" name="register_date" id="register_date" value="{{ old('register_date') }}">
                @if($errors->has('register_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('register_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitCompany.fields.register_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tax_number">{{ trans('cruds.benefitCompany.fields.tax_number') }}</label>
                <input class="form-control {{ $errors->has('tax_number') ? 'is-invalid' : '' }}" type="number" name="tax_number" id="tax_number" value="{{ old('tax_number', '') }}" step="1">
                @if($errors->has('tax_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tax_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitCompany.fields.tax_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tax_office">{{ trans('cruds.benefitCompany.fields.tax_office') }}</label>
                <input class="form-control {{ $errors->has('tax_office') ? 'is-invalid' : '' }}" type="text" name="tax_office" id="tax_office" value="{{ old('tax_office', '') }}">
                @if($errors->has('tax_office'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tax_office') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitCompany.fields.tax_office_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.benefitCompany.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitCompany.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city">{{ trans('cruds.benefitCompany.fields.city') }}</label>
                <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', '') }}">
                @if($errors->has('city'))
                    <div class="invalid-feedback">
                        {{ $errors->first('city') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitCompany.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="country">{{ trans('cruds.benefitCompany.fields.country') }}</label>
                <input class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" type="text" name="country" id="country" value="{{ old('country', '') }}">
                @if($errors->has('country'))
                    <div class="invalid-feedback">
                        {{ $errors->first('country') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.benefitCompany.fields.country_helper') }}</span>
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