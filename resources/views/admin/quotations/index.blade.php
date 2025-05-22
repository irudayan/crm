@extends('layouts.admin')
@section('title', __('cruds.quotation.title'))
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
                <div class="col-lg-10 col-sm-10 col-md-10 col-xs-12">
                    <h5>{{ trans('cruds.quotation.title_singular') }} {{ trans('global.list') }}</h5>
                </div>
                {{-- <button class="btn btn-success" data-toggle="modal" data-target="#createLeadsModal">
                    {{ trans('global.add') }} {{ trans('cruds.leads.title_singular') }}
                </button> --}}
                &nbsp;&nbsp;
                <a class="btn btn-sm btn-success"
                href="{{ route('admin.quotations.export') }}"
                style="float:right; margin-right: 5px;"
                title="Export to Excel">
                Export <i class="fa fa-file-excel-o" aria-hidden="true"></i>
            </a>

            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Lead">
                    <thead>
                        <tr>
                            <th><i class="fa fa-thumb-tack"></i></th>
                            <th>
                                {{ trans('cruds.leads.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.leads.fields.name') }}
                            </th>

                            <th>
                                {{ trans('cruds.leads.fields.mobile') }}
                            </th>
                            <th>
                                {{ trans('cruds.leads.fields.email') }}
                            </th>
                            <th>
                                {{ trans('cruds.leads.fields.products') }}
                            </th>
                            <th>
                                {{ trans('cruds.leads.fields.status') }}
                            </th>
                            <th>
                                {{ trans('cruds.leads.fields.created_at') }}
                            </th>

                            <th>
                                {{ trans('cruds.leads.fields.action') }}
                            </th>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input class="search form-control" type="text" placeholder="Search Name"></td>
                            <td><input class="search form-control" type="text" placeholder="Search Mobile"></td>
                            <td><input class="search form-control" type="text" placeholder="Search Email"></td>
                            <td><input class="search form-control" type="text" placeholder="Search Products"></td>
                            <td>

                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($leads as $lead)
                            <tr data-entry-id="{{ $lead->id }}" @if($lead->is_pinned) style="background-color: #fff3cd;" @endif>
                                <td style="text-align: center;">
                                    @if($lead->is_pinned)
                                        <i class="fa fa-star text-warning"></i>
                                    @endif
                                </td>
                                <td>{{ $lead->id }}</td>
                                <td>{{ $lead->name }}</td>
                                <td>{{ $lead->mobile }}</td>
                                <td>{{ $lead->email }}</td>

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

                                <td>{{ optional(\Carbon\Carbon::parse($lead->created_at))->format('d-m-Y g:i A') }}</td>
                                <td>


                                      <!-- Edit Button -->
                                      <button class="btn btn-xs btn-warning edit-lead" data-id="{{ $lead->id }}"
                                        data-name="{{ $lead->name }}" data-mobile="{{ $lead->mobile }}"
                                        data-email="{{ $lead->email }}" data-address="{{ $lead->address }}" data-industry="{{ $lead->industry }}"
                                        data-source="{{ $lead->source }}" data-assigned_name="{{ $lead->assigned_name }}"
                                        data-status="{{ $lead->status }}" data-purpose="{{ $lead->purpose }}"
                                        data-remarks="{{ $lead->remarks }}" data-assigned_to_remarks="{{ $lead->assigned_to_remarks }}" data-follow_date="{{ $lead->follow_date }}"
                                        data-follow_time="{{ $lead->follow_time }}" data-opened_at="{{ $lead->opened_at }}"
                                        data-products="{{ json_encode($lead->products->pluck('id')) }}" data-toggle="modal"
                                        data-target="#editLeadsModal">
                                        <i class="fa fa-edit"></i>
                                    </button>


                                    <!-- View Button -->
                                    <a class="btn btn-xs btn-primary view-lead" href="#"
                                        data-id="{{ $lead->id }}" data-name="{{ $lead->name }}"
                                        data-mobile="{{ $lead->mobile }}" data-email="{{ $lead->email }}"
                                        data-address="{{ $lead->address }}" data-industry="{{ $lead->industry }}"  data-source="{{ $lead->source }}" data-assigned_by="{{ $lead->assignedBy->name ?? 'Not Assigned' }}"
                                        data-assigned_name="{{ $lead->assign->name ?? 'Not Assigned' }}"
                                        data-status="{{ $lead->status }}" data-purpose="{{ $lead->purpose }}"
                                        data-remarks="{{ $lead->remarks }}" data-assigned_to_remarks="{{ $lead->assigned_to_remarks }}"
                                        data-products="{{ $lead->products->pluck('name')->implode(', ') }}"
                                        data-toggle="modal" data-target="#viewLeadsModal">
                                        <i class="fa fa-eye"></i>
                                    </a>


                                    @if ($lead->mail_status == '1')
                                        <i class="fa fa-check-circle green_color"></i>
                                    @else
                                        <i class="fa fa-times-circle red_color"></i>
                                    @endif
{{-- pin --}}
                                    <form action="{{ route('admin.leads.toggle-pin', $lead->id) }}" method="POST"
                                        style="display: inline-block;">
                                      @csrf
                                      <button type="submit" class="btn btn-xs btn-info"
                                              title="@if($lead->is_pinned) Unpin @else Pin @endif">
                                          <i class="fa fa-thumb-tack"></i>
                                      </button>
                                  </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Leads Modal -->
    {{-- @include('admin.leads.create') --}}

    <!-- View Leads Modal -->
    {{-- @include('admin.leads.show') --}}


       <!-- Edit Leads Modal -->
       <div class="modal fade" id="editLeadsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('global.edit') }} {{ trans('cruds.leads.title_singular') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editLeadForm" method="POST" action="#">
                        @csrf
                        @method('PUT')

                        <input type="hidden" id="edit_id" name="id">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="edit_name">{{ trans('cruds.leads.fields.name') }}</label>
                                    <input type="text" id="edit_name" class="form-control" name="name" required maxlength="30">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="edit_mobile">{{ trans('cruds.leads.fields.mobile') }}</label>
                                    <input type="text" id="edit_mobile" name="mobile" class="form-control" required maxlength="10" pattern="\d{10}" title="Please enter a 10-digit mobile number" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_email">{{ trans('cruds.leads.fields.email') }}</label>
                                    <input type="email" id="edit_email" class="form-control" name="email" maxlength="100">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_address">{{ trans('cruds.leads.fields.address') }}</label>
                                    <input type="text" id="edit_address" class="form-control" name="address"
                                     maxlength="300" >
                                </div>
                            </div>
                        </div>


                            <div class="form-group">
                                <label for="edit_industry">{{ trans('cruds.leads.fields.industry') }}</label>
                                <input type="text" id="edit_industry" class="form-control" name="industry" maxlength="100">
                            </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="product_idss">Select Products</label>
                                    <select class="form-control select2" name="product_ids[]" id="edit_product_ids"
                                        multiple required>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="assigned_name">{{ trans('cruds.leads.fields.assigned_name') }}</label>
                                    <select name="assigned_name" id="edit_assigned_name" class="form-control">
                                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                                        @foreach ($assignedName as $user)
                                            <option value="{{ $user->id }}"
                                                {{ isset($lead) && $lead->assigned_name == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>



                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="edit_status">{{ trans('cruds.leads.fields.status') }}</label>
                                    <select name="status" id="edit_status" class="form-control" required>
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
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="edit_source">{{ trans('cruds.leads.fields.source') }}</label>
                                    <select name="source" id="edit_source" class="form-control" required disabled>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="Twitter">Twitter (X)</option>
                                    <option value="LinkedIn">LinkedIn</option>
                                    <option value="YouTube">YouTube</option>
                                    <option value="WhatsApp">WhatsApp</option>
                                    <option value="Telegram">Telegram</option>
                                    <option value="CA / auditor">CA / auditor</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Customer Reference">Customer Reference</option>
                                    <option value="Just Dial">Just Dial</option>
                                    <option value="Dealers">Dealers</option>
                                    <option value="Website">Website</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        {{-- Follow Up Fields --}}
                        <div class="row" id="edit_followUpFields" style="display: none;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required" for="edit_follow_date">{{ trans('cruds.flowup.fields.follow_date') }}</label>
                                <input type="date" name="follow_date" id="edit_follow_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required" for="edit_follow_time">{{ trans('cruds.flowup.fields.follow_time') }}</label>
                                <input type="time" name="follow_time" id="edit_follow_time" class="form-control">
                            </div>
                        </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_purpose">{{ trans('cruds.leads.fields.purpose') }}</label>
                            <textarea id="edit_purpose" class="form-control" name="purpose" rows="2"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="edit_remarks">{{ trans('cruds.leads.fields.remarks') }}</label>
                            <textarea id="edit_remarks" class="form-control" name="remarks" rows="2"></textarea>
                        </div>

                         <div class="form-group">
                            <label for="edit_assigned_to_remarks">{{ trans('cruds.leads.fields.assigned_to_remarks') }}</label>
                            <textarea id="edit_assigned_to_remarks" class="form-control" name="assigned_to_remarks" rows="2"></textarea>
                        </div>

                        <div class="form-group mt-3">
                            <label class="font-weight-bold d-block" for="edit_opened_at">To accept Condition</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="edit_opened_at" name="edit_opened_at">
                                <label class="form-check-label" for="edit_opened_at">
                                    By submitting the above information, you agree to take responsibility for attending the lead.
                                </label>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ trans('global.cancel') }}</button>
                            <button type="submit" class="btn btn-primary">{{ trans('global.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <!-- View Leads Modal -->
    <div class="modal fade" id="viewLeadsModal" tabindex="-1" role="dialog" aria-labelledby="viewLeadsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewLeadsModalLabel">{{ trans('global.view') }}
                        {{ trans('cruds.leads.title_singular') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>{{ trans('cruds.leads.fields.id') }}</th>
                                <td id="viewId"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.leads.fields.name') }}</th>
                                <td id="viewName"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.leads.fields.mobile') }}</th>
                                <td id="viewMobile"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.leads.fields.email') }}</th>
                                <td id="viewEmail"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.leads.fields.address') }}</th>
                                <td id="viewAddress"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.leads.fields.industry') }}</th>
                                <td id="viewIndustry"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.leads.fields.products') }}</th>
                                <td id="viewProducts"></td>
                            </tr>
                            <tr>
                                <th>Assigned By</th>
                                <td id="viewAssignedBy"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.products.fields.assigned_name') }}</th>
                                <td id="viewAssignedName"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.leads.fields.source') }}</th>
                                <td id="viewSource"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.leads.fields.status') }}</th>
                                <td id="viewStatus"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.leads.fields.purpose') }}</th>
                                <td id="viewPurpose"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.leads.fields.remarks') }}</th>
                                <td id="viewRemarks"></td>
                            </tr>
                             <tr>
                                <th>{{ trans('cruds.leads.fields.assigned_to_remarks') }}</th>
                                <td id="viewAssignedToRemarks"></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{ trans('global.close') }}
                    </button>
                    <form id="quotationForm" method="POST">
{{-- @dd($lead->id); --}}
                        @csrf
                        <input type="hidden" value="1" name="mail_status" id="lead_id">
                        <button type="submit" class="btn btn-success">Send Email</button>
                    </form>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('lead_delete')
                let deleteButtonTrans =
                    '{{ trans('global.datatables.delete ') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.leads.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert(
                                '{{ trans('global.datatables.zero_selected ') }}'
                            )

                            return
                        }

                        if (confirm(
                                '{{ trans('global.areYouSure ') }}'
                            )) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
            });
            let table = $('.datatable-Lead:not(.ajaxTable)').DataTable({
                buttons: dtButtons,
                order: [[0, 'desc']]
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            let visibleColumnsIndexes = null;
            $('.datatable thead').on('input', '.search', function() {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value

                let index = $(this).parent().index()
                if (visibleColumnsIndexes !== null) {
                    index = visibleColumnsIndexes[index]
                }

                table
                    .column(index)
                    .search(value, strict)
                    .draw()
            });
            table.on('column-visibility.dt', function(e, settings, column, state) {
                visibleColumnsIndexes = []
                table.columns(":visible").every(function(colIdx) {
                    visibleColumnsIndexes.push(colIdx);
                });
            })
        });


           // Initialize Select2
           $('#product_idss').select2({
                placeholder: "Select Products",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#editLeadsModal')
            });


             function toggleEditFollowUpFields() {
            const status = $('#edit_status').val();
            if (status === 'Follow Up') {
                $('#edit_followUpFields').show();
                $('#edit_follow_date').attr('required', true);
                $('#edit_follow_time').attr('required', true);
            } else {
        $('#edit_followUpFields').hide();
        $('#edit_follow_date').removeAttr('required');
                $('#edit_follow_time').removeAttr('required');
            }
        }

          $('#edit_status').on('change', function () {
            toggleEditFollowUpFields();
        });


         // Handle Edit Button Click
         $('.edit-lead').on('click', function() {
                let leadId = $(this).data('id');

                // Set the form action URL dynamically
                $('#editLeadForm').attr('action', `/admin/leads/${leadId}`);

                // Set input values
                $('#edit_id').val(leadId);
                $('#edit_name').val($(this).data('name'));
                $('#edit_mobile').val($(this).data('mobile'));
                $('#edit_email').val($(this).data('email'));
                $('#edit_address').val($(this).data('address'));
                $('#edit_source').val($(this).data('source'));
                $('#edit_assigned_name').val($(this).data('assigned_name'));
                $('#edit_status').val($(this).data('status'));
                $('#edit_purpose').val($(this).data('purpose'));
                $('#edit_remarks').val($(this).data('remarks'));
                $('#edit_assigned_to_remarks').val($(this).data('assigned_to_remarks'));

                 $('#edit_follow_date').val($(this).data('follow_date'));
            $('#edit_follow_time').val($(this).data('follow_time'));


                // ✅ Correct handling of checkbox
                let openedAt = $(this).data('opened_at');
                if (openedAt && openedAt !== 'null' && openedAt !== null && openedAt !== '0000-00-00 00:00:00') {
                    $('#edit_opened_at').prop('checked', true);
                } else {
                    $('#edit_opened_at').prop('checked', false);
                }


                // Fetch selected products via AJAX
            $.ajax({
                url: `/admin/leads/${leadId}/products`,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        // Clear previous selections
                        $('#edit_product_ids').val(null).trigger('change');

                        // Set new selections
                        $('#edit_product_ids').val(response.products).trigger('change');
                    }
                },
                error: function(xhr) {
                    console.error("Error fetching products:", xhr.responseText);
                }
            });
            // Show follow-up fields if status is already "Follow Up"
            toggleEditFollowUpFields();
                        // Show modal
                        $('#editLeadsModal').modal('show');
                    });





        // Handle View Button Click
        $('.view-lead').on('click', function() {
            let leadId = $(this).data('id'); // 👈 Get lead ID
            let assignedName = $(this).data('assigned_name');
            $('#viewId').text($(this).data('id'));
            $('#viewName').text($(this).data('name'));
            $('#viewMobile').text($(this).data('mobile'));
            $('#viewEmail').text($(this).data('email'));
            $('#viewAddress').text($(this).data('address'));
            $('#viewIndustry').text($(this).data('industry'));
            $('#viewAssignedName').text(assignedName); // Corrected this line
            $('#viewAssignedBy').text($(this).data('assigned_by'));
            $('#viewSource').text($(this).data('source'));
            $('#viewStatus').text($(this).data('status'));
            $('#viewPurpose').text($(this).data('purpose'));
            $('#viewRemarks').text($(this).data('remarks'));
            $('#viewAssignedToRemarks').text($(this).data('assigned_to_remarks'));


            let products = $(this).data('products');
            $('#viewProducts').text(products ? products : 'No Products');

            // ✅ Update form action dynamically
            let routeUrl = `/admin/send-quotation/${leadId}`;
            $('#quotationForm').attr('action', routeUrl);

            // Show modal
            $('#viewLeadsModal').modal('show');
        });
    </script>
@endsection
