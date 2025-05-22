<!-- View Leads Modal -->
<div class="modal fade" id="viewLeadsModal" tabindex="-1" role="dialog" aria-labelledby="viewLeadsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
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
                            <th>{{ trans('cruds.leads.fields.products') }}</th>
                            <td id="viewProducts"></td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.leads.fields.assigned_by') }}</th>
                            <td id="viewAssignedBy"></td>
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
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">{{ trans('global.close') }}</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js">
        // Handle View Button Click
        $('.view-lead').on('click', function() {
            $('#viewId').text($(this).data('id'));
            $('#viewName').text($(this).data('name'));
            $('#viewMobile').text($(this).data('mobile'));
            $('#viewEmail').text($(this).data('email'));
            $('#viewAddress').text($(this).data('address'));
            $('#viewAssignedBy').text($(this).data('assigned_by'));
            $('#viewSource').text($(this).data('source'));
            $('#viewStatus').text($(this).data('status'));
            $('#viewPurpose').text($(this).data('purpose'));
            $('#viewRemarks').text($(this).data('remarks'));


            let products = $(this).data('products');
            $('#viewProducts').text(products ? products : 'No Products');

            // Show modal
            $('#viewLeadsModal').modal('show');
        });
    </script>
