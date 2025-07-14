@extends('layouts.admin')
@section('title', __('cruds.userDashboard.title'))
@section('content')
<div class="midde_cont">
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title">
                    <h2>{{ trans('cruds.userDashboard.title') }}</h2>
                </div>
            </div>
        </div>
        <div class="row column1">
            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30 yellow_bg">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-user"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">New Leads <b>{{ $newLeads }}</b></p>
                            <p>&nbsp;</p>
                            <p class="head_couter">Today New Leads <b>{{ $todayNewLeads }}</b> </p>
                            <p>&nbsp;</p><br>
                            <a href="{{ route('admin.leads.index') }}" class="small-box-footer">View All <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30 blue1_bg">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">Follow Up Leads <b>{{ $flowupLeads }}</b></p>
                            <p>&nbsp;</p>
                            <p class="head_couter">Today Follow Up Leads <b>{{ $todayFlowupLeads }}</b></p>
                            <p>&nbsp;</p><br>
                            <a href="{{ route('admin.followUp.index') }}" class="small-box-footer">View All <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30 green_bg">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-cloud-download"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">Closed or Won Leads <b>{{ $closedorwonLeads }}</b></p>
                            <p>&nbsp;</p>
                            <p class="head_couter">Today Closed or Won Leads {{ $todayClosedorwonLeads }}</b></p>
                            <p>&nbsp;</p>
                            <a href="{{ route('admin.closedOrWon.index') }}" class="small-box-footer">View All <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30 red_bg">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-comments-o"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">Appointments Leads <b>{{ $demoLeads }}</b></p>
                            <p>&nbsp;</p>
                            <p class="head_couter">Today Appointments Leads <b>{{ $todayDemoLeads }}</b></p>
                            <p>&nbsp;</p>
                            <a href="{{ route('admin.appointments.index') }}" class="small-box-footer">View All <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30 purple_bg">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-user-plus"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">{{ $assignedLeadsCount }}</p>
                            <p class="head_couter">Assigned By Me</p>
                            <p>&nbsp;</p>
                            <a href="{{ route('admin.our-leads.index') }}" class="small-box-footer">
                                View All <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            {{-- @if(auth()->id() == 1 && $userLeadsCount)
            <div class="col-md-12">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2>Leads Count per User</h2>
                    </div>
                </div>
                <div class="table_section padding_infor_info">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Total Leads</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userLeadsCount as $u)
                                <tr>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->total_leads }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif --}}

            {{-- @if(auth()->id() == 1 && $userLeadsCount)

            @foreach($userLeadsCount as $u)
            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30 purple_bg">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-user"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">{{ $u->total_leads }}</p>
                            <p class="head_couter">{{ $u->name }}</p>
                            <p>&nbsp;</p>
                            <a href="{{ route('admin.leads.index') }}" class="small-box-footer">
                                View Leads <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            @endif --}}
            {{-- @if(auth()->id() == 1 && $userLeadsCount) --}}
            @if(in_array(auth()->id(), [1, 2]) && $userLeadsCount)
            {{-- @dd('sdvfdgh'); --}}
            @foreach($userLeadsCount as $u)
            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30 purple_bg">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-user"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="head_couter">{{ $u->name }}</p><br>
                            <p class="total_no">Total Leads: <b>{{ $u->total_leads }}</b></p>
                            <p class="today_no" style="font-size: 14px; color: #17eaea; text-align:center">Today Leads:
                                {{ $u->today_leads }}</p>
                            <a href="{{ route('admin.leads.index') }}" class="small-box-footer" style="color: #fff;">
                                View Leads <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif


        </div>


        {{-- new table --}}



        {{-- <div class="row mb-3">
            <div class="col-md-4">
                <select id="dateFilter" class="form-control">
                    <option value="total">Total</option>
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="last_3_days">Last 3 Days</option>
                    <option value="last_7_days">Last 7 Days</option>
                    <option value="last_15_days">Last 15 Days</option>
                    <option value="last_30_days">Last 30 Days</option>
                    <option value="this_week">This Week</option>
                    <option value="last_week">Last Week</option>
                    <option value="this_month">This Month</option>
                    <option value="last_month">Last Month</option>
                    <option value="from_last_month">Last Month Onwards</option>
                    <option value="custom">Custom Range</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" id="startDate" class="form-control" style="display: none;">
            </div>
            <div class="col-md-3">
                <input type="date" id="endDate" class="form-control" style="display: none;">
            </div>
            <div class="col-md-2">
                <button id="applyFilter" class="btn btn-primary">Search</button>
            </div>
        </div>

        <div id="leadStatsTable">

            <div class="table_section padding_infor_info">
                <div class="table-responsive-sm">
                    <table class="table table-bordered" id="leadStatsTable">
                        <thead style="background-color: #033D75; color: white;">
                            <tr>
                                <th style="color: white">Name</th>
                                <th style="color: white">New</th>
                                <th style="color: white">Qualified</th>
                                <th style="color: white">Follow Up</th>
                                <th style="color: white">Appointments</th>
                                <th style="color: white">Quotations</th>
                                <th style="color: white">Won</th>
                                <th style="color: white">Cancel</th>
                                <th style="color: white">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userLeads as $lead)
                            <tr>
                                <td>{{ $lead->name ?? '-' }}</td>
                                <td>{{ $lead->new ?? 0 }}</td>
                                <td>{{ $lead->qualified ?? 0 }}</td>
                                <td>{{ $lead->follow_up ?? 0 }}</td>
                                <td>{{ $lead->appointments ?? 0 }}</td>
                                <td>{{ $lead->quotation ?? 0 }}</td>
                                <td>{{ $lead->won ?? 0 }}</td>
                                <td>{{ $lead->cancel ?? 0 }}</td>
                                <td>
                                    {{
                                    ($lead->new ?? 0) +
                                    ($lead->qualified ?? 0) +
                                    ($lead->follow_up ?? 0) +
                                    ($lead->appointments ?? 0) +
                                    ($lead->quotation ?? 0) +
                                    ($lead->won ?? 0) +
                                    ($lead->cancel ?? 0)
                                    }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background-color: #E9F3FC;">
                            <tr>
                                <th>Total</th>
                                <th>{{ $totals['qualified'] ?? 0 }}</th>
                                <th>{{ $totals['follow_up'] ?? 0 }}</th>
                                <th>{{ $totals['appointments'] ?? 0 }}</th>
                                <th>{{ $totals['quotation'] ?? 0 }}</th>
                                <th>{{ $totals['won'] ?? 0 }}</th>
                                <th>{{ $totals['cancel'] ?? 0 }}</th>
                                <th>{{ $totals['total'] ?? 0 }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div> --}}

        {{-- <div class="row mb-3">
            <div class="col-md-3">
                <select id="dateFilter" class="form-control">
                    <option value="total">Total</option>
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="last_3_days">Last 3 Days</option>
                    <option value="last_7_days">Last 7 Days</option>
                    <option value="last_15_days">Last 15 Days</option>
                    <option value="last_30_days">Last 30 Days</option>
                    <option value="this_week">This Week</option>
                    <option value="last_week">Last Week</option>
                    <option value="this_month">This Month</option>
                    <option value="last_month">Last Month</option>
                    <option value="from_last_month">Last Month Onwards</option>
                    <option value="custom">Custom Range</option>
                </select>
            </div>
            <div class="col-md-2">
                <select id="nameFilter" class="form-control">
                    <option value="all">All Names</option>
                    @foreach($assignedName as $user)
                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" id="startDate" class="form-control" style="display: none;">
            </div>
            <div class="col-md-2">
                <input type="date" id="endDate" class="form-control" style="display: none;">
            </div>
            <div class="col-md-2">
                <button id="applyFilter" class="btn btn-primary">Search</button>
            </div>
        </div>

        <div id="leadStatsTable">
            @include('admin.partials.lead_stats_table', [
            'userLeads' => $userLeads ?? collect(),
            'totals' => $totals ?? []
            ])
        </div> --}}

        <div class="row mb-3">
            <div class="col-md-3">
                <select id="dateFilter" class="form-control">
                    <option value="total">Total</option>
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="last_3_days">Last 3 Days</option>
                    <option value="last_7_days">Last 7 Days</option>
                    <option value="last_15_days">Last 15 Days</option>
                    <option value="last_30_days">Last 30 Days</option>
                    <option value="this_week">This Week</option>
                    <option value="last_week">Last Week</option>
                    <option value="this_month">This Month</option>
                    <option value="last_month">Last Month</option>
                    <option value="from_last_month">Last Month Onwards</option>
                    <option value="custom">Custom Range</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="nameFilter" class="form-control">
                    <option value="all">All Names</option>
                    @foreach($assignedName as $user)
                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" id="startDate" class="form-control" style="display: none;">
            </div>
            <div class="col-md-2">
                <input type="date" id="endDate" class="form-control" style="display: none;">
            </div>
            <div class="col-md-2">
                <button id="applyFilter" class="btn btn-primary">Search</button>
            </div>
        </div>

        <div id="leadStatsTable">
            <div class="table_section padding_infor_info">
                <div class="table-responsive-sm">
                    <table class="table table-bordered">
                        <thead style="background-color: #033D75; color: white;">
                            <tr>
                                <th style="color: white">Name</th>
                                <th style="color: white">New</th>
                                <th style="color: white">Qualified</th>
                                <th style="color: white">Follow Up</th>
                                <th style="color: white">Appointments</th>
                                <th style="color: white">Quotations</th>
                                <th style="color: white">Won</th>
                                <th style="color: white">Cancel</th>
                                <th style="color: white">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userLeads as $lead)
                            <tr>
                                <td>{{ $lead->name ?? '-' }}</td>
                                <td>{{ $lead->new ?? 0 }}</td>
                                <td>{{ $lead->qualified ?? 0 }}</td>
                                <td>{{ $lead->follow_up ?? 0 }}</td>
                                <td>{{ $lead->appointments ?? 0 }}</td>
                                <td>{{ $lead->quotation ?? 0 }}</td>
                                <td>{{ $lead->won ?? 0 }}</td>
                                <td>{{ $lead->cancel ?? 0 }}</td>
                                <td>{{ $lead->total ?? 0 }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        @if($totals)
                        <tfoot style="background-color: #E9F3FC;">
                            <tr>
                                <th>Total</th>
                                <th>{{ $totals['new'] ?? 0 }}</th>
                                <th>{{ $totals['qualified'] ?? 0 }}</th>
                                <th>{{ $totals['follow_up'] ?? 0 }}</th>
                                <th>{{ $totals['appointments'] ?? 0 }}</th>
                                <th>{{ $totals['quotation'] ?? 0 }}</th>
                                <th>{{ $totals['won'] ?? 0 }}</th>
                                <th>{{ $totals['cancel'] ?? 0 }}</th>
                                <th>{{ $totals['total'] ?? 0 }}</th>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>




        <!-- table today leads section -->
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2>Today Follow Up Leads</h2>
                    </div>
                </div>
                <div class="table_section padding_infor_info">
                    <div class="table-responsive-sm">
                        <table class="table table-hover">
                            <thead>
                                <tr>
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
                                        {{ trans('cruds.leads.fields.assigned_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.leads.fields.products') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.leads.fields.status') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.flowup.fields.follow_date') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.flowup.fields.follow_time') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.leads.fields.action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($followupLeads as $lead)
                                <tr data-entry-id="{{ $lead->id }}">
                                    <td>{{ $lead->id }}</td>
                                    <td>{{ $lead->name }}</td>
                                    <td>{{ $lead->mobile }}</td>
                                    <td>{{ $lead->assign->name ?? 'Not Assigned' }}</td>
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
                                        @elseif ($lead->status == 'Demo')
                                        <span class="badge badge-primary">Demo</span>
                                        @elseif ($lead->status == 'Quotation / Ready To Buy')
                                        <span class="badge badge-dark">Quotation / Ready To Buy</span>
                                        @elseif ($lead->status == 'Closed or Won')
                                        <span class="badge badge-success">Closed or Won</span>
                                        @elseif ($lead->status == 'Dropped or Cancel')
                                        <span class="badge badge-secondary">Dropped or Cancel</span>
                                        @else
                                        <span class="badge badge-light">Unknown</span>
                                        @endif
                                    </td>
                                    <td>{{
                                        optional(\Carbon\Carbon::parse($lead->follow_date))->format('d-m-Y')
                                        }}
                                    </td>
                                    <td>{{
                                        optional(\Carbon\Carbon::parse($lead->follow_time))->format('g:i
                                        A') }}
                                    </td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-xs btn-warning edit-lead" data-id="{{ $lead->id }}"
                                            data-name="{{ $lead->name }}" data-mobile="{{ $lead->mobile }}"
                                            data-email="{{ $lead->email }}" data-address="{{ $lead->address }}"
                                            data-industry="{{ $lead->industry }}" data-source="{{ $lead->source }}"
                                            data-assigned_name="{{ $lead->assigned_name }}"
                                            data-status="{{ $lead->status }}" data-purpose="{{ $lead->purpose }}"
                                            data-remarks="{{ $lead->remarks }}"
                                            data-follow_date="{{ $lead->follow_date }}"
                                            data-follow_time="{{ $lead->follow_time }}"
                                            data-products="{{ json_encode($lead->products->pluck('id')) }}"
                                            data-toggle="modal" data-target="#editLeadsModal">
                                            <i class="fa fa-edit"></i>
                                        </button>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- table section -->
        <div class="modal fade" id="editLeadsModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trans('global.edit') }} {{
                            trans('cruds.leads.title_singular') }}
                        </h5>
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
                                        <label class="required" for="edit_name">{{
                                            trans('cruds.leads.fields.name')
                                            }}</label>
                                        <input type="text" id="edit_name" class="form-control" name="name" required
                                            maxlength="30">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required" for="edit_mobile">{{
                                            trans('cruds.leads.fields.mobile')
                                            }}</label>
                                        {{-- <input type="text" id="edit_mobile" class="form-control" name="mobile"
                                            required> --}}
                                        <input type="text" id="edit_mobile" name="mobile" class="form-control" required
                                            maxlength="12" pattern="\d{10}"
                                            title="Please enter a 12-digit mobile number"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12)">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_email">{{ trans('cruds.leads.fields.email')
                                            }}</label>
                                        <input type="email" id="edit_email" class="form-control" name="email"
                                            maxlength="100">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_address">{{ trans('cruds.leads.fields.address')
                                            }}</label>
                                        <input type="text" id="edit_address" class="form-control" name="address">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="edit_industry">{{ trans('cruds.leads.fields.industry')
                                    }}</label>
                                <input type="text" id="edit_industry" class="form-control" name="industry"
                                    maxlength="100">
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required" for="product_idss">Select
                                            Products</label>
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
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="assigned_name">{{
                                            trans('cruds.leads.fields.assigned_name')
                                            }}</label>
                                        <select name="assigned_name" id="edit_assigned_name" class="form-control">
                                            <option value="">{{ trans('global.pleaseSelect') }}</option>
                                            @foreach ($assignedName as $user)
                                            <option value="{{ $user->id }}" {{ isset($lead) && $lead->
                                                assigned_name ==
                                                $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div> --}}



                            </div>

                            <div class="row">



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required" for="edit_status">{{
                                            trans('cruds.leads.fields.status')
                                            }}</label>
                                        <select name="status" id="edit_status" class="form-control" required>
                                            <option value="New">New</option>
                                            <option value="Qualified">Qualified</option>
                                            <option value="Follow Up">Follow Up</option>
                                            <option value="Online Demo">Online Demo</option>
                                            <option value="Offline Demo">Offline Demo</option>
                                            <option value="Onsite Visit">Onsite Visit</option>
                                            <option value="Quotation / Ready To Buy">Quotation / Ready
                                                To Buy</option>
                                            <option value="Closed or Won">Closed or Won</option>
                                            <option value="Dropped or Cancel">Dropped or Cancel</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required" for="edit_source">{{
                                            trans('cruds.leads.fields.source')
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
                                            <option value="Customer Reference">Customer Reference
                                            </option>
                                            <option value="Just Dial">Just Dial</option>
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
                                        <input type="date" name="follow_date" id="edit_follow_date"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required" for="edit_follow_time">{{
                                            trans('cruds.flowup.fields.follow_time') }}</label>
                                        <input type="time" name="follow_time" id="edit_follow_time"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="edit_purpose">{{ trans('cruds.leads.fields.purpose')
                                    }}</label>
                                <textarea id="edit_purpose" class="form-control" name="purpose" rows="2"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="edit_remarks">{{ trans('cruds.leads.fields.remarks')
                                    }}</label>
                                <textarea id="edit_remarks" class="form-control" name="remarks" rows="2"></textarea>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{
                                    trans('global.cancel') }}</button>
                                <button type="submit" class="btn btn-primary">{{ trans('global.save')
                                    }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- table today leads section -->
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2>Today Leads in a CRM</h2>
                    </div>
                </div>
                <div class="table_section padding_infor_info">
                    <div class="table-responsive-sm">
                        <table class="table table-hover">
                            <thead>
                                <tr>
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
                                        {{ trans('cruds.leads.fields.assigned_name') }}
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

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leads as $lead)
                                <tr data-entry-id="{{ $lead->id }}">
                                    <td>{{ $lead->id }}</td>
                                    <td>{{ $lead->name }}</td>
                                    <td>{{ $lead->mobile }}</td>
                                    <td>{{ $lead->assign->name ?? 'Not Assigned' }}</td>
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
                                        @elseif ($lead->status == 'Demo')
                                        <span class="badge badge-primary">Demo</span>
                                        @elseif ($lead->status == 'Quotation / Ready To Buy')
                                        <span class="badge badge-dark">Quotation / Ready To Buy</span>
                                        @elseif ($lead->status == 'Closed or Won')
                                        <span class="badge badge-success">Closed or Won</span>
                                        @elseif ($lead->status == 'Dropped or Cancel')
                                        <span class="badge badge-secondary">Dropped or Cancel</span>
                                        @else
                                        <span class="badge badge-light">Unknown</span>
                                        @endif
                                    </td>

                                    <td>{{
                                        optional(\Carbon\Carbon::parse($lead->created_at))->format('d-m-Y
                                        g:i A') }}
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- table section -->

        <!-- progress bar -->
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2>Recent leads Bar </h2>
                    </div>
                </div>
                <div class="full progress_bar_inner">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="progress_bar">
                                <!-- Skill Bars -->

                                <span class="skill">Total Leads <span class="info_valume">&nbsp;{{
                                        $totalLeads
                                        }}%</span></span>
                                <div class="progress skill-bar ">
                                    <div class="progress-bar progress-bar-animated progress-bar-striped"
                                        role="progressbar" aria-valuenow="{{ $totalLeads }}" aria-valuemin="0"
                                        aria-valuemax="100" style="width: {{ $totalLeads }}%;">
                                    </div>
                                </div>

                                <span class="skill">New Leads <span class="info_valume">&nbsp;{{
                                        $newLeads
                                        }}%</span></span>
                                <div class="progress skill-bar">
                                    <div class="progress-bar progress-bar-animated progress-bar-striped"
                                        role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ $newLeads }}%;">
                                    </div>
                                </div>


                                <span class="skill">Qualified Leads <span class="info_valume">&nbsp;{{
                                        $qualifiedLeads
                                        }}%</span></span>
                                <div class="progress skill-bar">
                                    <div class="progress-bar progress-bar-animated progress-bar-striped"
                                        role="progressbar" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ $qualifiedLeads }}%;">
                                    </div>
                                </div>

                                <span class="skill">Follow Up Leads <span class="info_valume">&nbsp;{{
                                        $flowupLeads
                                        }}%</span></span>
                                <div class="progress skill-bar">
                                    <div class="progress-bar progress-bar-animated progress-bar-striped"
                                        role="progressbar" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ $flowupLeads }}%;">
                                    </div>
                                </div>

                                <span class="skill">Appointments Leads <span class="info_valume">&nbsp;{{ $demoLeads
                                        }}%</span></span>
                                <div class="progress skill-bar">
                                    <div class="progress-bar progress-bar-animated progress-bar-striped"
                                        role="progressbar" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ $demoLeads }}%;">
                                    </div>
                                </div>

                                <span class="skill">Quotation / Ready To Buy Leads <span class="info_valume">&nbsp;{{
                                        $closedorwonLeads }}%</span></span>
                                <div class="progress skill-bar">
                                    <div class="progress-bar progress-bar-animated progress-bar-striped"
                                        role="progressbar" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ $closedorwonLeads }}%;">
                                    </div>
                                </div>


                                <span class="skill">Closed or Won Leads <span class="info_valume">&nbsp;{{ $cancelLeads
                                        }}%</span></span>
                                <div class="progress skill-bar">
                                    <div class="progress-bar progress-bar-animated progress-bar-striped"
                                        role="progressbar" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ $cancelLeads }}%;">
                                    </div>
                                </div>

                                <span class="skill">Dropped or Cancel Leads <span class="info_valume">&nbsp;{{
                                        $cancelLeads }}%</span></span>
                                <div class="progress skill-bar">
                                    <div class="progress-bar progress-bar-animated progress-bar-striped"
                                        role="progressbar" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ $cancelLeads }}%;">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end progress bar -->


        <div class="container-fluid">
            <div class="footer">
                <p>Copyright © 2025 All rights reserved | Desigined and hosted
                    <a href="https://isaral.in/">by iSaral Business
                        Solutions Pvt Ltd</a>
                </p>
            </div>
        </div>

    </div>
    <!-- footer -->
    {{-- <div class="container-fluid">
        <div class="footer">
            <p>Copyright © 2025 All rights reserved | Desigined and hosted
                <a href="https://isaral.in/">by iSaral Business
                    Solutions Pvt Ltd</a>
            </p>
        </div>
    </div> --}}
</div>
@endsection

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- <script>
    $('#dateFilter').on('change', function () {
        if ($(this).val() === 'custom') {
            $('#startDate, #endDate').show();
        } else {
            $('#startDate, #endDate').hide();
        }
    });

    $('#applyFilter').on('click', function () {
        let filter = $('#dateFilter').val();
        let start = $('#startDate').val();
        let end = $('#endDate').val();

        $.ajax({
            url: "{{ route('admin.filter.leads') }}",
            method: "GET",
            data: { filter: filter, start: start, end: end },
            beforeSend: function () {
                $('#leadStatsTable').html('Loading...');
            },
            success: function (response) {
                $('#leadStatsTable').html(response.html);
            }
        });
    });
</script> --}}

{{-- <script>
    $(document).ready(function() {
        // Show/hide date inputs based on filter selection
        $('#dateFilter').on('change', function() {
            if ($(this).val() === 'custom') {
                $('#startDate, #endDate').show();
            } else {
                $('#startDate, #endDate').hide();
            }
        });

        // Apply filter button click handler
        $('#applyFilter').on('click', function() {
            let filter = $('#dateFilter').val();
            let start = $('#startDate').val();
            let end = $('#endDate').val();

            // Validate custom dates if custom filter is selected
            if (filter === 'custom' && (!start || !end)) {
                alert('Please select both start and end dates for custom range');
                return;
            }

            $.ajax({
                url: "{{ route('admin.filter.leads') }}",
                method: "GET",
                data: {
                    filter: filter,
                    start: start,
                    end: end
                },
                beforeSend: function() {
                    $('#leadStatsTable').html('<div class="text-center">Loading...</div>');
                },
                success: function(response) {
                    if (response.html) {
                        $('#leadStatsTable').html(response.html);
                    } else {
                        $('#leadStatsTable').html('<div class="text-danger">No data found</div>');
                    }
                },
                error: function() {
                    $('#leadStatsTable').html('<div class="text-danger">Error loading data</div>');
                }
            });
        });
    });
</script> --}}

<script>
    $(document).ready(function() {
    // Show/hide date inputs based on filter selection
    $('#dateFilter').on('change', function() {
        if ($(this).val() === 'custom') {
            $('#startDate, #endDate').show();
        } else {
            $('#startDate, #endDate').hide();
        }
    });

    // Apply filter button click handler
    $('#applyFilter').on('click', function() {
        let filter = $('#dateFilter').val();
        let start = $('#startDate').val();
        let end = $('#endDate').val();
        let name = $('#nameFilter').val();

        // Validate custom dates if custom filter is selected
        if (filter === 'custom' && (!start || !end)) {
            alert('Please select both start and end dates for custom range');
            return;
        }

        $.ajax({
            url: "{{ route('admin.filter.leads') }}",
            method: "GET",
            data: {
                filter: filter,
                start: start,
                end: end,
                name: name
            },
            beforeSend: function() {
                $('#leadStatsTable').html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
            },
            success: function(response) {
                if (response.html) {
                    $('#leadStatsTable').html(response.html);
                } else {
                    $('#leadStatsTable').html('<div class="alert alert-warning">No data found for the selected filter</div>');
                }
            },
            error: function(xhr) {
                let errorMsg = 'Error loading data';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }
                $('#leadStatsTable').html('<div class="alert alert-danger">' + errorMsg + '</div>');
                console.error('Error:', xhr.responseText);
            }
        });
    });
});
</script>

{{-- <script>
    $(document).ready(function() {
    // Show/hide date inputs based on filter selection
    $('#dateFilter').on('change', function() {
        if ($(this).val() === 'custom') {
            $('#startDate, #endDate').show();
        } else {
            $('#startDate, #endDate').hide();
        }
    });

    // Apply filter button click handler
    $('#applyFilter').on('click', function() {
        let filter = $('#dateFilter').val();
        let start = $('#startDate').val();
        let end = $('#endDate').val();
        let name = $('#nameFilter').val();

        // Validate custom dates if custom filter is selected
        if (filter === 'custom' && (!start || !end)) {
            alert('Please select both start and end dates for custom range');
            return;
        }

        $.ajax({
            url: "{{ route('admin.filter.leads') }}",
            method: "GET",
            data: {
                filter: filter,
                start: start,
                end: end,
                name: name
            },
            beforeSend: function() {
                $('#leadStatsTable').html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
            },
            success: function(response) {
                if (response.html) {
                    $('#leadStatsTable').html(response.html);
                } else {
                    $('#leadStatsTable').html('<div class="alert alert-warning">No data found for the selected filter</div>');
                }
            },
            error: function(xhr) {
                let errorMsg = 'Error loading data';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }
                $('#leadStatsTable').html('<div class="alert alert-danger">' + errorMsg + '</div>');
                console.error('Error:', xhr.responseText);
            }
        });
    });
});

</script> --}}

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
            $('.datatable thead').on('input', '.search', function () {
            let index = $(this).parent().index();
            let value = this.value;
            table
                .column(index)
                .search(value)
                .draw();
        })
        });



        // Initialize Select2
        $('#edit_product_ids').select2({
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
            let assignedName = $(this).data('assigned_name');

            // Set form action URL
            $('#editLeadForm').attr('action', `/admin/leads/${leadId}`);

            // Populate form fields
            $('#edit_id').val(leadId);
            $('#edit_name').val($(this).data('name'));
            $('#edit_mobile').val($(this).data('mobile'));
            $('#edit_email').val($(this).data('email'));
            $('#edit_address').val($(this).data('address'));
            $('#edit_industry').val($(this).data('industry'));
            $('#edit_source').val($(this).data('source'));
            $('#edit_assigned_name').val(assignedName);
            $('#edit_status').val($(this).data('status'));
            $('#edit_purpose').val($(this).data('purpose'));
            $('#edit_remarks').val($(this).data('remarks'));
             // Set follow-up fields
    $('#edit_follow_date').val($(this).data('follow_date'));
    $('#edit_follow_time').val($(this).data('follow_time'));

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
            let assignedName = $(this).data('assigned_name');
            let assignedBy = $(this).data('assigned_by'); // NEW

            $('#viewId').text($(this).data('id'));
            $('#viewName').text($(this).data('name'));
            $('#viewMobile').text($(this).data('mobile'));
            $('#viewEmail').text($(this).data('email'));
            $('#viewAddress').text($(this).data('address'));
            $('#viewIndustry').text($(this).data('industry'));
            $('#viewAssignedName').text(assignedName); // Corrected this line
            $('#viewAssignedBy').text(assignedBy); // NEW
            $('#viewSource').text($(this).data('source'));
            $('#viewStatus').text($(this).data('status'));
            $('#viewPurpose').text($(this).data('purpose'));
            $('#viewRemarks').text($(this).data('remarks'));
            $('#viewOpentAt').text($(this).data('opened_at'));


            let products = $(this).data('products');
            $('#viewProducts').text(products ? products : 'No Products');

            // Show modal
            $('#viewLeadsModal').modal('show');
        });
</script>
@endsection
