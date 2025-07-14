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
                    <td>{{ $lead['name'] ?? '-' }}</td>
                    <td><a href="#" class="count-link" data-status="New" data-user="{{ $lead['name'] ?? 'all' }}">{{
                            $lead['new'] ?? 0 }}</a></td>
                    <td><a href="#" class="count-link" data-status="Qualified"
                            data-user="{{ $lead['name'] ?? 'all' }}">{{ $lead['qualified'] ?? 0 }}</a></td>
                    <td><a href="#" class="count-link" data-status="Follow Up"
                            data-user="{{ $lead['name'] ?? 'all' }}">{{ $lead['follow_up'] ?? 0 }}</a></td>
                    <td><a href="#" class="count-link" data-status="appointments"
                            data-user="{{ $lead['name'] ?? 'all' }}">{{ $lead['appointments'] ?? 0 }}</a></td>
                    <td><a href="#" class="count-link" data-status="quotation"
                            data-user="{{ $lead['name'] ?? 'all' }}">{{ $lead['quotation'] ?? 0 }}</a></td>
                    <td><a href="#" class="count-link" data-status="Closed or Won"
                            data-user="{{ $lead['name'] ?? 'all' }}">{{ $lead['won'] ?? 0 }}</a></td>
                    <td><a href="#" class="count-link" data-status="Dropped or Cancel"
                            data-user="{{ $lead['name'] ?? 'all' }}">{{ $lead['cancel'] ?? 0 }}</a></td>
                    <td><a href="#" class="count-link" data-status="all" data-user="{{ $lead['name'] ?? 'all' }}">{{
                            $lead['total'] ?? 0 }}</a></td>
                </tr>
                @endforeach
            </tbody>
            @if(isset($totals))
            <tfoot style="background-color: #E9F3FC;">
                <tr>
                    <th>Total</th>
                    <th><a href="#" class="count-link" data-status="New">{{ $totals['new'] ?? 0 }}</a></th>
                    <th><a href="#" class="count-link" data-status="Qualified">{{ $totals['qualified'] ?? 0 }}</a></th>
                    <th><a href="#" class="count-link" data-status="Follow Up">{{ $totals['follow_up'] ?? 0 }}</a></th>
                    <th><a href="#" class="count-link" data-status="appointments">{{ $totals['appointments'] ?? 0 }}</a>
                    </th>
                    <th><a href="#" class="count-link" data-status="quotation">{{ $totals['quotation'] ?? 0 }}</a></th>
                    <th><a href="#" class="count-link" data-status="Closed or Won">{{ $totals['won'] ?? 0 }}</a></th>
                    <th><a href="#" class="count-link" data-status="Dropped or Cancel">{{ $totals['cancel'] ?? 0 }}</a>
                    </th>
                    <th><a href="#" class="count-link" data-status="all">{{ $totals['total'] ?? 0 }}</a></th>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
