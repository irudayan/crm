@extends('layouts.admin')
@section('title', __('cruds.quotation.title'))
@section('content')
<p>&nbsp;</p>
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


@endsection

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
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
</script>
