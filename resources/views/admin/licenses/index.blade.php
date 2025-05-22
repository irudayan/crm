@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">License Keys</h4>
        <div class="float-right">
            <a href="{{ route('admin.licenses.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Create License
            </a>
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#bulkGenerateModal">
                <i class="fa fa-copy"></i> Bulk Generate
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>License Key</th>
                        <th>Email</th>
                        <th>Plan</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($licenses as $license)
                        <tr>
                            <td><code>{{ $license->license_key }}</code></td>
                            <td>{{ $license->email }}</td>
                            <td>{{ ucfirst($license->plan) }}</td>
                            <td>{{ $license->start_date->format('Y-m-d') }}</td>
                            <td>{{ $license->end_date->format('Y-m-d') }}</td>
                            <td>
                                <span class="badge badge-{{ $license->status == 'Active' ? 'success' : ($license->status == 'Expired' ? 'warning' : 'danger') }}">
                                    {{ $license->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.licenses.show', $license) }}" class="btn btn-sm btn-info" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.licenses.download', $license) }}" class="btn btn-sm btn-secondary" title="Download">
                                    <i class="fa fa-download"></i>
                                </a>
                                <form action="{{ route('admin.licenses.toggleStatus', $license) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-{{ $license->is_active ? 'warning' : 'success' }}" title="{{ $license->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="fa fa-{{ $license->is_active ? 'times' : 'check' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.licenses.destroy', $license) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No licenses found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $licenses->links() }}
    </div>
</div>

<!-- Bulk Generate Modal -->
<div class="modal fade" id="bulkGenerateModal" tabindex="-1" role="dialog" aria-labelledby="bulkGenerateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkGenerateModalLabel">Bulk Generate Licenses</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.licenses.bulkGenerate') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="count">Number of Licenses</label>
                        <input type="number" class="form-control" id="count" name="count" min="1" max="100" value="10" required>
                    </div>
                    <div class="form-group">
                        <label for="plan">License Plan</label>
                        <select class="form-control" id="plan" name="plan" required>
                            <option value="trial">Trial (10 days)</option>
                            <option value="1year">1 Year</option>
                            <option value="2years">2 Years</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
