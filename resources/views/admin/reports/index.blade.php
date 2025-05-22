@extends('layouts.admin')

@section('title', __('cruds.reports.title'))

@section('content')
<p>&nbsp;</p>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-lg-10">
                <h5>{{ trans('cruds.reports.title_singular') }} {{ trans('global.list') }}</h5>
            </div>
        </div>
    </div>
    <br>

    <form action="{{ route('admin.reports.index') }}" method="GET" class="form-inline mb-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="date" name="start_date" class="form-control mr-2" value="{{ request('start_date') }}">
        <input type="date" name="end_date" class="form-control mr-2" value="{{ request('end_date') }}">

        <select name="status" class="form-control mr-2">
            <option value="">All Status</option>
            @foreach(['New','Qualified','Follow Up','Online Demo','Offline Demo','Onsite Visit','Quotation / Ready To Buy','Closed or Won','Dropped or Cancel'] as $status)
                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
        </select>

        <select name="assigned_by" class="form-control mr-2">
            <option value="">All Assigned By</option>
            @foreach($assignedByUsers as $user)
                <option value="{{ $user->id }}" {{ request('assigned_by') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
            @endforeach
        </select>

        <select name="assigned_user" class="form-control mr-2">
            <option value="">All Assigned To</option>
            @foreach($assignedName as $user)
                <option value="{{ $user->id }}" {{ request('assigned_user') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
            @endforeach
        </select>

        <select name="product" class="form-control mr-2">
            <option value="">All Products</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}" {{ request('product') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary mr-2">
            Search <i class="fa fa-search"></i>
        </button>

        <a class="btn btn-warning mr-2" href="{{ route('admin.reports.index') }}">
            Clear Search <i class="fa fa-times"></i>
        </a>
       <br> <br> <br><br>
        <a class="btn btn-success  mr-2" href="{{ route('admin.reports.export', request()->query()) }}">
            Export <i class="fa fa-file-excel-o"></i>
        </a>


        <a class="btn btn-sm btn-success  mr-2" href="{{ route('admin.reports.export') }}">
            All Export <i class="fa fa-file-excel-o"></i>
        </a>
    </form>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Lead">
                <thead>
                    <tr>
                        <th>{{ trans('cruds.leads.fields.id') }}</th>
                        <th>{{ trans('cruds.leads.fields.name') }}</th>
                        <th>{{ trans('cruds.leads.fields.mobile') }}</th>
                        <th>{{ trans('cruds.leads.fields.products') }}</th>
                        <th>{{ trans('cruds.leads.fields.status') }}</th>
                        <th>Assigned By</th>
                        <th>Assigning To</th>
                        <th>{{ trans('cruds.leads.fields.created_at') }}</th>
                        {{-- <th>Updated Name</th> --}}
                        {{-- <th>Updated At</th> --}}
                        <th>{{ trans('cruds.leads.fields.action') }}</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input class="search form-control" type="text" placeholder="Search Name" /></td>
                        <td><input class="search form-control" type="text" placeholder="Search Mobile" /></td>
                        <td><input class="search form-control" type="text" placeholder="Search Products" /></td>
                        <td>
                            <select class="search form-control">
                                <option value="">{{ trans('global.all') }}</option>
                                <option value="New">New</option>
                                <option value="Qualified">Qualified</option>
                                <option value="Follow Up">Follow Up</option>
                                <option value="Online Demo">Online Demo</option>
                                <option value="Offline Demo">Offline Demo</option>
                                <option value="Onsite Visit">Onsite Visit</option>
                                <option value="Quotation / Ready To Buy">Quotation / Ready To Buy</option>
                                <option value="Closed or Won">Closed or Won</option>
                                <option value="Dropped or Cancel">Dropped or Cancel</option>
                            </select>
                        </td>
                        <td><input class="search form-control" type="text" placeholder="Search Assigned By" /></td>
                        <td><input class="search form-control" type="text" placeholder="Search Created At (e.g. 29-04-2025)" /></td>
                        <td><input class="search form-control" type="text" placeholder="Search Updated Name" /></td>
                        {{-- <td><input class="search form-control" type="text" placeholder="Search Updated At (e.g. 29-04-2025)" /></td> --}}
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leads as $lead)
                        <tr data-entry-id="{{ $lead->id }}">
                            <td>{{ $lead->id }}</td>
                            <td>{{ $lead->name }}</td>
                            <td>{{ $lead->mobile }}</td>
                            <td>
                                @if ($lead->products->isNotEmpty())
                                    @foreach ($lead->products as $product)
                                        <span class="badge badge-info">{{ $product->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No Products</span>
                                @endif
                            </td>
                            <td>
                                @if ($lead->status == 'New')
                                <span class="badge badge-info">New</span>
                            @elseif ($lead->status == 'Qualified')
                                <span class="badge badge-success">Qualified</span>
                            @elseif ($lead->status == 'Follow Up')
                                <span class="badge badge-warning">Follow Up</span>
                            @elseif ($lead->status == 'Online Demo')
                                <span class="badge badge-primary">Online Demo</span>
                            @elseif ($lead->status == 'Offline Demo')
                                <span class="badge badge-danger">Offline Demo</span>
                            @elseif ($lead->status == 'Onsite Visit')
                                <span class="badge badge-secondary">Onsite Visit</span>
                            @elseif ($lead->status == 'Quotation / Ready To Buy')
                                <span class="badge badge-dark">Quotation / Ready To Buy</span>
                            @elseif ($lead->status == 'Closed or Won')
                                <span class="badge badge-success">Closed or Won</span>
                            @elseif ($lead->status == 'Dropped or Cancel')
                                <span class="badge badge-light">Dropped or Cancel</span>
                            @else
                                <span class="badge badge-light">Unknown</span>
                            @endif
                            </td>
                            <td>{{ $lead->assignedBy->name ?? 'Not Assigned' }}</td>
                            <td>{{ $lead->assign->name ?? 'Not assigned' }}</td>
                            <td>{{ \Carbon\Carbon::parse($lead->created_at)->format('d-m-Y g:i A') }}</td>
                            {{-- <td>{{ $lead->lastUpdateBy->name ?? 'Not Updated' }}</td> --}}
                            {{-- <td>{{ \Carbon\Carbon::parse($lead->updated_at)->format('d-m-Y g:i A') }}</td> --}}
                            <td>
                                <a class="btn btn-xs btn-primary view-lead"
                                    href="#"
                                    data-id="{{ $lead->id }}"
                                    data-name="{{ $lead->name }}"
                                    data-mobile="{{ $lead->mobile }}"
                                    data-email="{{ $lead->email }}"
                                    data-address="{{ $lead->address }}"
                                    data-industry="{{ $lead->industry }}"
                                    data-source="{{ $lead->source }}"
                                    data-assigned_by="{{ $lead->assignedBy->name ?? 'Not Assigned' }}"
                                    data-assigned_name="{{ $lead->assign->name ?? 'Not Assigned' }}"
                                    data-status="{{ $lead->status }}"
                                    data-purpose="{{ $lead->purpose }}"
                                    data-remarks="{{ $lead->remarks }}"
                                    data-assigned_to_remarks="{{ $lead->assigned_to_remarks }}"
                                    data-opened_at="{{ $lead->opened_at ? \Carbon\Carbon::parse($lead->opened_at)->format('d-m-Y g:i A') : 'Not Opened' }}"
                                    data-last_updated_by="{{ $lead->lastUpdateBy->name ?? 'Not Updated' }}"
                                    data-updated_at="{{ \Carbon\Carbon::parse($lead->updated_at)->format('d-m-Y g:i A') }}"
                                    data-products="{{ $lead->products->pluck('name')->implode(', ') }}"
                                    data-toggle="modal" data-target="#viewLeadsModal">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewLeadsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Lead</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr><th>ID</th><td id="viewId"></td></tr>
                        <tr><th>Name</th><td id="viewName"></td></tr>
                        <tr><th>Mobile</th><td id="viewMobile"></td></tr>
                        <tr><th>Email</th><td id="viewEmail"></td></tr>
                        <tr><th>Address</th><td id="viewAddress"></td></tr>
                        <tr><th>Industry</th><td id="viewIndustry"></td></tr>
                        <tr><th>Products</th><td id="viewProducts"></td></tr>
                        <tr><th>Assigned By</th><td id="viewAssignedBy"></td></tr>
                        <tr><th>{{ trans('cruds.products.fields.assigned_name') }}</th><td id="viewAssignedName"></td></tr>
                        <tr><th>Source</th><td id="viewSource"></td></tr>
                        <tr><th>Status</th><td id="viewStatus"></td></tr>
                        <tr><th>Purpose</th><td id="viewPurpose"></td></tr>
                        <tr><th>Assigned By Remarks</th><td id="viewRemarks"></td></tr>
                         <tr>
                                <th>{{ trans('cruds.leads.fields.assigned_to_remarks') }}</th>
                                <td id="viewAssignedToRemarks"></td>
                            </tr>
                        <tr><th>Opened At</th><td id="viewOpentAt"></td>
                        <tr><th>Last Updated Name</th><td id="viewLastUpdatedBy"></td></tr>
                        <tr><th>Updated At</th><td id="viewUpdatedAt"></td></tr>

                    </tbody>
                </table>
                <!-- Modal Footer (should be outside the table) -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{ trans('global.cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(function() {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

        let table = $('.datatable-Lead').DataTable({
            buttons: dtButtons,
            orderCellsTop: true,
            order: [[0, 'desc']],
            initComplete: function() {
                // Re-bind the click event handlers after DataTables redraws
                this.api().on('draw', function() {
                    bindViewLeadEvents();
                });
                bindViewLeadEvents();
            }
        });

        function bindViewLeadEvents() {
            $('.view-lead').off('click').on('click', function() {
                $('#viewId').text($(this).data('id'));
                $('#viewName').text($(this).data('name'));
                $('#viewMobile').text($(this).data('mobile'));
                $('#viewEmail').text($(this).data('email'));
                $('#viewAddress').text($(this).data('address'));
                $('#viewIndustry').text($(this).data('industry'));
                $('#viewProducts').text($(this).data('products'));
                $('#viewAssignedName').text($(this).data('assigned_name'));
                $('#viewAssignedBy').text($(this).data('assigned_by'));
                $('#viewSource').text($(this).data('source'));
                $('#viewStatus').text($(this).data('status'));
                $('#viewPurpose').text($(this).data('purpose'));
                $('#viewRemarks').text($(this).data('remarks'));
                $('#viewAssignedToRemarks').text($(this).data('assigned_to_remarks'));
                $('#viewOpentAt').text($(this).data('opened_at'));
                $('#viewUpdatedAt').text($(this).data('updated_at'));
                $('#viewLastUpdatedBy').text($(this).data('last_updated_by'));
            });
        }

        $('.datatable thead').on('input', '.search', function() {
            let index = $(this).parent().index();
            let value = this.value;
            table
                .column(index)
                .search(value)
                .draw();
        });
    });
</script>
@endsection
