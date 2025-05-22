@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Create New License</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.licenses.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="plan">License Plan</label>
                <select class="form-control" id="plan" name="plan" required>
                    <option value="trial">Trial (10 days)</option>
                    <option value="1year">1 Year</option>
                    <option value="2years">2 Years</option>
                </select>
            </div>
            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create License</button>
            <a href="{{ route('admin.licenses.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
