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
            <a class="btn btn-sm btn-success" href="{{ route('admin.quotations.export') }}"
                style="float:right; margin-right: 5px;" title="Export to Excel">
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
                                data-email="{{ $lead->email }}" data-address="{{ $lead->address }}"
                                data-industry="{{ $lead->industry }}" data-source="{{ $lead->source }}"
                                data-assigned_name="{{ $lead->assigned_name }}" data-status="{{ $lead->status }}"
                                data-purpose="{{ $lead->purpose }}" data-remarks="{{ $lead->remarks }}"
                                data-assigned_to_remarks="{{ $lead->assigned_to_remarks }}"
                                data-follow_date="{{ $lead->follow_date }}" data-follow_time="{{ $lead->follow_time }}"
                                data-call_back_date="{{ $lead->call_back_date }}"
                                data-call_back_time="{{ $lead->call_back_time }}"
                                data-opened_at="{{ $lead->opened_at }}"
                                data-products="{{ json_encode($lead->products->pluck('id')) }}" data-toggle="modal"
                                data-target="#editLeadsModal">
                                <i class="fa fa-edit"></i>
                            </button>

                            {{-- quotation --}}


                            <button class="btn btn-xs btn-secondary edit-quotation" data-id="{{ $lead->id }}"
                                data-name="{{ $lead->name }}" data-mobile="{{ $lead->mobile }}"
                                data-email="{{ $lead->email }}" data-address="{{ $lead->address }}"
                                data-industry="{{ $lead->industry }}" data-purpose="{{ $lead->purpose }}"
                                data-about_us="{{ ($lead->about_us) }}"
                                data-products="{{ $lead->products->pluck('id')->implode(',') }}"
                                data-quotation_amount="{{ $lead->quotation_amount }}"
                                data-quotation_tax="{{ $lead->quotation_tax }}"
                                data-quotation_reference="{{ $lead->quotation_reference }}"
                                data-quotation_validity="{{ $lead->quotation_validity }}"
                                data-quotation_expiry_date="{{ $lead->quotation_expiry_date }}"
                                data-quotation_terms='@json($lead->quotation_terms ?? [])'
                                data-quotation_notes="{{ ($lead->quotation_notes) }}"
                                data-opened_at="{{ $lead->opened_at }}" data-toggle="modal"
                                data-target="#qutationeditLeadsModal">
                                <i class="fa fa-file-text-o"></i>
                            </button>


                            <!-- PDF + Email Buttons (only if PDF exists) -->




                            <!-- View Button -->
                            <a class="btn btn-xs btn-primary view-lead" href="#" data-id="{{ $lead->id }}"
                                data-name="{{ $lead->name }}" data-mobile="{{ $lead->mobile }}"
                                data-email="{{ $lead->email }}" data-address="{{ $lead->address }}"
                                data-industry="{{ $lead->industry }}" data-source="{{ $lead->source }}"
                                data-assigned_by="{{ $lead->assignedBy->name ?? 'Not Assigned' }}"
                                data-assigned_name="{{ $lead->assign->name ?? 'Not Assigned' }}"
                                data-call_back_date="{{ $lead->call_back_date }}"
                                data-call_back_time="{{ $lead->call_back_time }}" data-status="{{ $lead->status }}"
                                data-purpose="{{ $lead->purpose }}" data-remarks="{{ $lead->remarks }}"
                                data-assigned_to_remarks="{{ $lead->assigned_to_remarks }}"
                                data-products="{{ $lead->products->pluck('name')->implode(', ') }}" data-toggle="modal"
                                data-target="#viewLeadsModal">
                                <i class="fa fa-eye"></i>
                            </a>

                            {{-- pin --}}
                            <form action="{{ route('admin.leads.toggle-pin', $lead->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-xs btn-info"
                                    title="@if($lead->is_pinned) Unpin @else Pin @endif">
                                    <i class="fa fa-thumb-tack"></i>
                                </button>
                            </form>

                            @if ($lead->mail_status == '1')
                            <i class="fa fa-check-circle green_color"></i>
                            @else
                            <i class="fa fa-times-circle red_color"></i>
                            @endif

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
                                <input type="text" id="edit_name" class="form-control" name="name" required
                                    maxlength="30">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required" for="edit_mobile">{{ trans('cruds.leads.fields.mobile')
                                    }}</label>
                                <input type="text" id="edit_mobile" name="mobile" class="form-control" required
                                    maxlength="10" pattern="\d{10}" title="Please enter a 10-digit mobile number"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
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
                                    maxlength="300">
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
                                <select class="form-control select2" name="product_ids[]" id="edit_product_ids" multiple
                                    required>
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
                                    <option value="{{ $user->id }}" {{ isset($lead) && $lead->assigned_name == $user->id
                                        ? 'selected' : '' }}>
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
                                <label class="required" for="edit_status">{{ trans('cruds.leads.fields.status')
                                    }}</label>
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
                                <label class="required" for="edit_source">{{ trans('cruds.leads.fields.source')
                                    }}</label>
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
                                <label class="required" for="edit_follow_date">{{
                                    trans('cruds.flowup.fields.follow_date') }}</label>
                                <input type="date" name="follow_date" id="edit_follow_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required" for="edit_follow_time">{{
                                    trans('cruds.flowup.fields.follow_time') }}</label>
                                <input type="time" name="follow_time" id="edit_follow_time" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_call_back_date">{{
                                    trans('cruds.flowup.fields.call_back_date') }}</label>
                                <input type="date" name="call_back_date" id="edit_call_back_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_call_back_time">{{
                                    trans('cruds.flowup.fields.call_back_time') }}</label>
                                <input type="time" name="call_back_time" id="edit_call_back_time" class="form-control">
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
                        <label for="edit_assigned_to_remarks">{{ trans('cruds.leads.fields.assigned_to_remarks')
                            }}</label>
                        <textarea id="edit_assigned_to_remarks" class="form-control" name="assigned_to_remarks"
                            rows="2"></textarea>
                    </div>

                    <div class="form-group mt-3">
                        <label class="font-weight-bold d-block" for="edit_opened_at">To accept Condition</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="edit_opened_at" name="edit_opened_at">
                            <label class="form-check-label" for="edit_opened_at">
                                By submitting the above information, you agree to take responsibility for attending the
                                lead.
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('global.cancel')
                            }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('global.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Quotation Edit Modal -->

<div class="modal fade" id="qutationeditLeadsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Quotation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editQuotationForm" method="POST"
                    action="{{ route('admin.quotations.update-quotation', ['id' => '__ID__']) }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="quotation_edit_id" name="id">
                    <input type="hidden" id="product_details_json" name="product_details_json">

                    <!-- Quotation Specific Section -->
                    <div class="card mb-3">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Quotation Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="required" for="quotation_edit_name">Name</label>
                                        <input type="text" id="quotation_edit_name" class="form-control" name="name"
                                            required maxlength="30">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="required" for="quotation_edit_mobile">Mobile</label>
                                        <input type="text" id="quotation_edit_mobile" name="mobile" class="form-control"
                                            required maxlength="10" pattern="\d{10}"
                                            title="Please enter a 10-digit mobile number"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="quotation_edit_email">Email</label>
                                        <input type="email" id="quotation_edit_email" class="form-control" name="email"
                                            maxlength="100">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="quotation_edit_address">Address</label>
                                        <input type="text" id="quotation_edit_address" class="form-control"
                                            name="address" maxlength="300">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="quotation_edit_industry">Industry</label>
                                        <input type="text" id="quotation_edit_industry" class="form-control"
                                            name="industry" maxlength="100">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="quotation_edit_about_us">About Us</label>
                                <textarea id="quotation_edit_about_us" class="form-control" name="about_us" rows="2"
                                    required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="quotation_edit_purpose">Purpose</label>
                                <textarea id="quotation_edit_purpose" class="form-control" name="purpose" rows="2"
                                    required></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="required" for="quotation_product_ids">Select Products</label>
                                        <select class="form-control select2" name="product_ids[]"
                                            id="quotation_product_ids" multiple required>
                                            @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                                data-tax="{{ $product->tax }}">
                                                {{ $product->name }}
                                                {{-- (₹ {{ number_format($product->price, 2) }}) (%{{$product->tax }})
                                                --}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Rows Container -->
                            <div id="products-container">
                                <!-- Dynamic product rows will be added here -->
                            </div>

                            <!-- Summary Fields -->
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="quotation_amount">Subtotal</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">₹</span>
                                            </div>
                                            <input type="number" id="quotation_amount" class="form-control"
                                                name="quotation_amount" step="0.01" min="0" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="quotation_discount_amount">Total Discount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">₹</span>
                                            </div>
                                            <input type="number" id="quotation_discount_amount" class="form-control"
                                                name="quotation_discount" step="0.01" min="0" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="quotation_tax_amount">Total Tax</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">₹</span>
                                            </div>
                                            <input type="number" id="quotation_tax_amount" class="form-control"
                                                name="quotation_tax" step="0.01" min="0" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="quotation_total">Grand Total</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">₹</span>
                                            </div>
                                            <input type="number" id="quotation_total" class="form-control"
                                                name="quotation_total" step="0.01" min="0" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="quotation_reference">Reference ID</label>
                                        <input type="text" id="quotation_reference" class="form-control"
                                            name="quotation_reference" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="quotation_validity">Quotation Validity (Days)</label>
                                        <input type="number" id="quotation_validity" class="form-control"
                                            name="quotation_validity" min="1" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="quotation_expiry_date">Quotation Expiry Date</label>
                                        <input type="date" id="quotation_expiry_date" class="form-control"
                                            name="quotation_expiry_date" required>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label>Terms & Conditions</label>
                                <div class="terms-options">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="terms[]" id="term1"
                                            value="Installation by online/Offline, depending on client requirement.">
                                        <label class="form-check-label" for="term1">
                                            Installation by online/Offline, depending on client requirement.
                                        </label>
                                    </div>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="terms[]" id="term2"
                                            value="Visiting Client Place only @ Bangalore, Rest of Bangalore only online.">
                                        <label class="form-check-label" for="term2">
                                            Visiting Client Place only @ Bangalore, Rest of Bangalore only online.
                                        </label>
                                    </div>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="terms[]" id="term3"
                                            value="Add-on will be provided @ Free of cost (According to the Plan).">
                                        <label class="form-check-label" for="term3">
                                            Add-on will be provided @ Free of cost (According to the Plan).
                                        </label>
                                    </div>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="terms[]" id="term4"
                                            value="Existing Customized Tools will be given @ 50% Discount.">
                                        <label class="form-check-label" for="term4">
                                            Existing Customized Tools will be given @ 50% Discount.
                                        </label>
                                    </div>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="terms[]" id="term5"
                                            value="Telephonic and remote support has always been the very strong point of iSaral.">
                                        <label class="form-check-label" for="term5">
                                            Telephonic and remote support has always been the very strong point of
                                            iSaral.
                                        </label>
                                    </div>
                                </div>

                                <div class="custom-terms mt-3" style="display: none;">
                                    <label for="additional_terms">Additional Terms</label>
                                    <textarea id="additional_terms" class="form-control" name="additional_terms"
                                        rows="3" placeholder="Enter any additional terms..."></textarea>
                                </div>

                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="addCustomTerms">
                                    <label class="form-check-label" for="addCustomTerms">
                                        Add custom terms
                                    </label>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="quotation_notes">Additional Notes</label>
                                <textarea id="quotation_notes" class="form-control" name="quotation_notes" rows="2"
                                    required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="quotation_opened_at"
                                name="quotation_opened_at" required>
                            <label class="form-check-label" for="quotation_opened_at">
                                By submitting the above information, you agree to take responsibility for attending the
                                lead.
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" id="sendEmailBtn" class="btn btn-success">Send Email</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
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
                            <th>{{ trans('cruds.flowup.fields.call_back_date') }}</th>
                            <td id="viewcallbackdate"></td>
                        </tr>

                        <tr>
                            <th>{{ trans('cruds.flowup.fields.call_back_time') }}</th>
                            <td id="viewcallbacktime"></td>
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
                <form id="editQuotationForm" method="POST">
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
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>


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


// quotation

$(document).ready(function() {
    // Initialize Select2 for product selection
    $('#quotation_product_ids').select2({
        placeholder: "Select Products",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#qutationeditLeadsModal')
    });

    // Toggle custom terms textarea
    $('#addCustomTerms').change(function() {
        $('.custom-terms').toggle(this.checked);
    });

    // Container for product rows
    const $productsContainer = $('#products-container');

    // Add new product row when product is selected
    $('#quotation_product_ids').on('change', function() {
        updateProductRows();
        calculateQuotationTotals();
    });

    // Handle changes in product fields
    $(document).on('input', '.product-price, .product-discount, .product-tax', function() {
        calculateQuotationTotals();
    });

    // Remove product row - fixed event delegation
    $(document).on('click', '.remove-product', function(e) {
        e.preventDefault();
        const $row = $(this).closest('.product-row');
        const productId = $row.data('product-id');

        $row.remove();

        // Update the select2 to remove this product
        const $select = $('#quotation_product_ids');
        const selected = $select.val() || [];
        const index = selected.indexOf(productId.toString());
        if (index !== -1) {
            selected.splice(index, 1);
            $select.val(selected).trigger('change');
        }

        calculateQuotationTotals();
    });

    function updateProductRows() {
        const selectedProducts = $('#quotation_product_ids').val() || [];
        const existingProductIds = $('.product-row').map(function() {
            return $(this).data('product-id').toString();
        }).get();

        // Add new product rows only for products not already rendered
        selectedProducts.forEach(productId => {
            productId = productId.toString();
            if (!existingProductIds.includes(productId)) {
                const $selectedOption = $('#quotation_product_ids option[value="' + productId + '"]');
                const productName = $selectedOption.text().split(' (₹')[0];
                const defaultPrice = parseFloat($selectedOption.data('price')) || 0;
                const defaultTax = parseFloat($selectedOption.data('tax')) || 0;

                const $row = $(`
                    <div class="product-row row mb-2" data-product-id="${productId}">
                        <div class="col-md-4">
                            <input type="text" class="form-control product-name" value="${productName}" readonly>
                            <input type="hidden" class="product-id" name="products[${productId}][id]" value="${productId}">
                        </div>
                        <div class="col-md-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₹</span>
                                </div>
                                <input type="number" class="form-control product-price"
                                       name="products[${productId}][price]"
                                       value="${defaultPrice.toFixed(2)}" step="0.01" min="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group">
                                <input type="number" class="form-control product-discount"
                                       name="products[${productId}][discount]"
                                       value="0" min="0" max="100">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group">
                                <input type="number" class="form-control product-tax"
                                       name="products[${productId}][tax]"
                                       value="${defaultTax}" min="0" max="100">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-product">Remove</button>
                        </div>
                    </div>
                `);

                $productsContainer.append($row);
            }
        });

        // Remove rows for products that are no longer selected
        $('.product-row').each(function() {
            const productId = $(this).data('product-id').toString();
            if (!selectedProducts.includes(productId)) {
                $(this).remove();
            }
        });
    }

    function calculateQuotationTotals() {
        let subtotal = 0;
        let totalDiscount = 0;
        let totalTax = 0;
        let productDetails = [];

        $('.product-row').each(function() {
            const $row = $(this);
            const productId = $row.data('product-id');
            const productName = $row.find('.product-name').val();
            const price = parseFloat($row.find('.product-price').val()) || 0;
            const discount = parseFloat($row.find('.product-discount').val()) || 0;
            const tax = parseFloat($row.find('.product-tax').val()) || 0;

            // Ensure values are within reasonable limits
            const discountAmount = Math.min(price * (discount / 100), price);
            const priceAfterDiscount = price - discountAmount;
            const taxAmount = priceAfterDiscount * (tax / 100);

            subtotal += price;
            totalDiscount += discountAmount;
            totalTax += taxAmount;

            productDetails.push({
                id: productId,
                name: productName,
                price: price,
                discount: discount,
                tax: tax,
                price_after_discount: priceAfterDiscount,
                tax_amount: taxAmount,
                total: priceAfterDiscount + taxAmount
            });
        });

        const grandTotal = subtotal - totalDiscount + totalTax;

        // Update summary fields with proper rounding
        $('#quotation_amount').val((subtotal - totalDiscount).toFixed(2));
        $('#quotation_discount_amount').val(totalDiscount.toFixed(2));
        $('#quotation_tax_amount').val(totalTax.toFixed(2));
        $('#quotation_total').val(grandTotal.toFixed(2));

        // Store product details in hidden field
        $('#product_details_json').val(JSON.stringify(productDetails));
    }

    // Handle Edit Button Click for quotation edit
$('.edit-quotation').on('click', function() {
    let leadId = $(this).data('id');
    let leadData = $(this).data();

    // Set the form action URL dynamically
    $('#editQuotationForm').attr('action', $('#editQuotationForm').attr('action').replace('__ID__', leadId));

    // Set input values
    $('#quotation_edit_id').val(leadId);
    $('#quotation_edit_name').val(leadData.name);
    $('#quotation_edit_mobile').val(leadData.mobile);
    $('#quotation_edit_email').val(leadData.email);
    $('#quotation_edit_address').val(leadData.address);
    $('#quotation_edit_industry').val(leadData.industry);
    $('#quotation_edit_purpose').val(leadData.purpose);
    $('#quotation_edit_about_us').val(leadData.about_us);
    $('#quotation_amount').val(leadData.quotation_amount);
    $('#quotation_discount_amount').val(leadData.quotation_discount || 0);
    $('#quotation_tax_amount').val(leadData.quotation_tax || 0);
    $('#quotation_total').val(leadData.quotation_total || 0);
    $('#quotation_reference').val(leadData.quotation_reference);
    $('#quotation_validity').val(leadData.quotation_validity);
    $('#quotation_notes').val(leadData.quotation_notes);

    // Set expiry date if it exists
    if (leadData.quotation_expiry_date && leadData.quotation_expiry_date !== '0000-00-00') {
        const expiryDate = new Date(leadData.quotation_expiry_date);
        if (!isNaN(expiryDate.getTime())) {
            const formattedDate = expiryDate.toISOString().split('T')[0];
            $('#quotation_expiry_date').val(formattedDate);
        }
    }

    // Fetch selected products via AJAX
    $.ajax({
        url: `/admin/leads/${leadId}/products`,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                // Clear previous selections
                $('#quotation_product_ids').val(null).trigger('change');
                $productsContainer.empty();

                // Set new selections
                if (response.products && response.products.length > 0) {
                    $('#quotation_product_ids').val(response.products).trigger('change');
                }

                // If we have detailed product info, populate the rows
                if (response.product_details && response.product_details.length > 0) {
                    response.product_details.forEach(product => {
                        const $row = $(`
                            <div class="product-row row mb-2" data-product-id="${product.id}">
                                <div class="col-md-4">
                                    <input type="text" class="form-control product-name" value="${product.name}" readonly>
                                    <input type="hidden" class="product-id" name="products[${product.id}][id]" value="${product.id}">
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₹</span>
                                        </div>
                                        <input type="number" class="form-control product-price"
                                               name="products[${product.id}][price]"
                                               value="${product.price.toFixed(2)}" step="0.01" min="0">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input type="number" class="form-control product-discount"
                                               name="products[${product.id}][discount]"
                                               value="${product.discount || 0}" min="0" max="100">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input type="number" class="form-control product-tax"
                                               name="products[${product.id}][tax]"
                                               value="${product.tax}" min="0" max="100">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-product">Remove</button>
                                </div>
                            </div>
                        `);

                        $productsContainer.append($row);
                    });
                }

                calculateQuotationTotals();
            }
        },
        error: function(xhr) {
            console.error("Error fetching products:", xhr.responseText);
        }
    });


 // Set terms checkboxes
       // Set terms checkboxes
if (leadData.quotation_terms) {
    try {
        const terms = JSON.parse(leadData.quotation_terms.replace(/&quot;/g, '"'));

        // Uncheck all initially
        $('input[name="terms[]"]').prop('checked', false);
        $('#addCustomTerms').prop('checked', false);
        $('#additional_terms').val('').parent().hide();

        terms.forEach(term => {
            let matched = false;
            $('input[name="terms[]"]').each(function() {
                if ($(this).val().trim() === term.trim()) {
                    $(this).prop('checked', true);
                    matched = true;
                }
            });

            // Handle custom terms
            if (!matched) {
                $('#addCustomTerms').prop('checked', true).trigger('change');
                $('#additional_terms').val(term);
            }
        });
    } catch (e) {
        console.error('Error parsing quotation_terms:', e);
    }
}

        // Handle checkbox
        let openedAt = leadData.openedAt;
        if (openedAt && openedAt !== 'null' && openedAt !== null && openedAt !== '0000-00-00 00:00:00') {
            $('#quotation_opened_at').prop('checked', true);
        } else {
            $('#quotation_opened_at').prop('checked', false);
        }
    });

    // Handle form submission
    $('#editQuotationForm').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const url = form.attr('action');
        const formData = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // $('#qutationeditLeadsModal').modal('hide');
                    window.location.reload();
                }
            },
            error: function(xhr) {
                console.error('Error saving quotation');
            }
        });
    });

    // Handle Send Email button click
    $('#sendEmailBtn').on('click', function() {
        const leadId = $('#quotation_edit_id').val();
        const email = $('#quotation_edit_email').val();

        if (!email) {
            alert('Please enter an email address before sending.');
            return;
        }

        // First save the form
        const form = $('#editQuotationForm');
        const url = form.attr('action');
        const formData = form.serialize() + '&send_email=true';

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {

                if (response.success) {
                    if (response.pdf_url) {
                        // Open PDF in new tab
                        window.open(response.pdf_url, '_blank');
                    }
                    window.location.reload();
                    $('#qutationeditLeadsModal').modal('hide');
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('Error saving quotation before sending email');
            }
        });
    });

    // Set expiry date based on validity days
    $('#quotation_validity').on('change', function() {
        const validityDays = parseInt($(this).val());
        if (validityDays && validityDays > 0) {
            const today = new Date();
            const expiryDate = new Date(today.setDate(today.getDate() + validityDays));
            const formattedDate = expiryDate.toISOString().split('T')[0];
            $('#quotation_expiry_date').val(formattedDate);
        }
    });
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

                $('#edit_call_back_date').val($(this).data('call_back_date'));
                $('#edit_call_back_time').val($(this).data('call_back_time'));


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

                // Get raw date/time from data attributes
    let rawDate = $(this).data('call_back_date'); // e.g., "2025-06-03"
    let rawTime = $(this).data('call_back_time'); // e.g., "15:30:00"

            let formattedDate = moment(rawDate).format('DD-MM-YYYY');
            let formattedTime = moment(rawTime, 'HH:mm:ss').format('hh:mm A'); // "03:30 PM"


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
            $('#viewcallbackdate').text(formattedDate);
            $('#viewcallbacktime').text(formattedTime);
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