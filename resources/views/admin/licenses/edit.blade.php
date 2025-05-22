@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Edit License</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.licenses.update', $license) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $license->email }}" required>
            </div>
            <div class="form-group">
                <label for="is_active">Status</label>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" {{ $license->is_active ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_active">{{ $license->is_active ? 'Active' : 'Inactive' }}</label>
                </div>
            </div>
            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ $license->notes }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update License</button>
            <a href="{{ route('admin.licenses.show', $license) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
