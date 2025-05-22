@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Activate License</h4>
    </div>
    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.licenses.activate') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="license_key">License Key</label>
                <input type="text" class="form-control" id="license_key" name="license_key" required>
                <small class="form-text text-muted">Enter your license key to activate the software</small>
            </div>
            <button type="submit" class="btn btn-primary">Activate License</button>
        </form>
    </div>
</div>
@endsection
