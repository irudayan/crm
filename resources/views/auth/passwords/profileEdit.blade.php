@extends('layouts.admin')
@section('title', __('cruds.user.fields.password'))
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
                            <h5>{{ trans('global.my_profile') }}</h5>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 text-right">
                            <div style="margin-bottom: 10px;" class="row">
                                <div class="col-lg-12">
                                    <a class="btn btn-sm btn-dark" href="{{ route('admin.home') }}" style="float:right;"
                                        title="{{ trans('global.back') }}">
                                        Back <i class="fa fa-backward" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.password.updateProfile') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                    name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required>
                                @if ($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                                    name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                                    required>
                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="profile_image">{{ __('Profile Image') }} (Max: 2MB, JPG/PNG/GIF)</label>
                                <input type="file" name="profile_image" id="profile_image"
                                    class="form-control-file @error('profile_image') is-invalid @enderror" accept="image/*"
                                    onchange="previewImage(event)">
                                @error('profile_image')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">
                                    {{ __('Leave empty to keep current image') }}
                                </small>
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('Current Image') }}</label><br>
                                <img id="image_preview"
                                    src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) : asset('backend/images/layout_img/user_img.jpg') }}"
                                    width="120" height="120" class="img-thumbnail" style="object-fit: cover;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    type="password" name="password" id="password">
                                @if ($errors->has('password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                                <small class="form-text text-muted">
                                    {{ __('Leave empty to keep current password') }}
                                </small>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                <input class="form-control" type="password" name="password_confirmation"
                                    id="password_confirmation">
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">
                                {{ trans('global.save') }}
                            </button>
                            <a class="btn btn-light ml-2" title="{{ trans('global.cancel') }}"
                                href="{{ route('admin.home') }}">
                                {{ trans('global.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('image_preview');
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
