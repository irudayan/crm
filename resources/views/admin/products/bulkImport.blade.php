@extends('layouts.admin')
@section('title', __('cruds.products.title_singular'))
@section('content')


<p>&nbsp;</p>

@if(session('message'))
<div class="alert alert-success">{{ session('message') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif


<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
                <h5> <i class="fas fa-file-import"></i>&nbsp;{{ trans('global.bulk') }}</h5>
            </div>
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 text-right">
                <a class="btn btn-sm btn-danger" href="{{ url('excel/products.xlsx') }}"
                    style="float:right; margin-right: 10px;"  download>Download
                    <i class="fa fa-file-download" aria-hidden="true"></i>
                </a>&nbsp;&nbsp;
                <a class="btn btn-sm btn-dark" href="{{ route('admin.products.index') }}"
                    title="{{ trans('global.back') }}" style="float: right;margin-right: 5px;">
                   Back <i class="fa fa-backward" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.products.bulk-import-store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="form-group col-md-6">
                    <label class="required" for="institution_id">{{ trans('cruds.products.fields.excel_import') }} File</label>
                    <input class="form-control {{ $errors->has('file') ? 'is-invalid' : '' }}" type="file"
                        name="file" id="file" value="{{ old('file', '') }}" accept="xlsx" required>


                    <span id="upload-error" style="color: red;"></span>
                </div>
            </div>

            <p>
                <i class="fa fa-arrow-right" aria-hidden="true"></i><span style="color: red;">
                    {{ trans('global.file_helper') }}</span><br>


            </p>

            <div class="form-group">
                <button class="btn btn-dark" type="submit">
                    {{ trans('global.upload') }}
                </button>&nbsp;
                <a class="btn btn-light" title="{{ trans('global.cancel') }}"
                    href="{{ route('admin.products.index') }}">
                    {{ trans('global.cancel') }}</a>
            </div>
        </form>
    </div>
</div>




@endsection
@section('scripts')

<script>
    $('form').submit(function() {
        $(this).find("button[type='submit']").prop('disabled', true);
    });

    $('#file').change(
        function() {
            var fileExtension = ['xlsx'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                $('#upload-error').text("{{ trans('global.file_helper') }}");
                setTimeout(function() {
                    $("#upload-error").fadeOut(1000, function() {
                        $(this).empty().fadeIn(100);
                    });
                }, 1200);
                this.value = ''; // Clean field
                return false;
            }
        });
</script>

@endsection
