@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">License Details</h4>
        <div class="float-right">
            <a href="{{ route('admin.licenses.download', $license) }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-download"></i> Download
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>License Key</label>
                    <input type="text" class="form-control" value="{{ $license->license_key }}" readonly>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" value="{{ $license->email }}" readonly>
                </div>
                <div class="form-group">
                    <label>Plan</label>
                    <input type="text" class="form-control" value="{{ ucfirst($license->plan) }}" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="text" class="form-control" value="{{ $license->start_date->format('Y-m-d') }}" readonly>
                </div>
                <div class="form-group">
                    <label>End Date</label>
                    <input type="text" class="form-control" value="{{ $license->end_date->format('Y-m-d') }}" readonly>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" value="{{ $license->status }}" readonly>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Notes</label>
            <textarea class="form-control" rows="3" readonly>{{ $license->notes }}</textarea>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.licenses.edit', $license) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('admin.licenses.toggleStatus', $license) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-{{ $license->is_active ? 'warning' : 'success' }}">
                    {{ $license->is_active ? 'Deactivate' : 'Activate' }}
                </button>
            </form>
            <a href="{{ route('admin.licenses.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
