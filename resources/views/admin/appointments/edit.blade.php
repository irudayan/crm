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
                                <label for="edit_name">{{ trans('cruds.leads.fields.name') }}</label>
                                <input type="text" id="edit_name" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_mobile">{{ trans('cruds.leads.fields.mobile') }}</label>
                                <input type="text" id="edit_mobile" class="form-control" name="mobile" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_email">{{ trans('cruds.leads.fields.email') }}</label>
                                <input type="email" id="edit_email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_address">{{ trans('cruds.leads.fields.address') }}</label>
                                <input type="text" id="edit_address" class="form-control" name="address" required>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required" for="product_idss">Select Products</label>
                                {{-- <select name="product_ids[]" id="product_idss" class="form-control select2" multiple
                                    required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ in_array($product->id, $selectedProducts) ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select> --}}
                                {{-- <select name="product_ids[]" id="product_idss" class="form-control select2" multiple
                                    required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select> --}}
                                <select name="product_ids[]" id="product_ids" class="form-control select2" multiple
                                    required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ in_array($product->id, $selectedProducts) ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_status">{{ trans('cruds.leads.fields.status') }}</label>
                                <select name="status" id="edit_status" class="form-control" required>
                                    <option value="New">New</option>
                                    <option value="Demo">Demo</option>
                                    <option value="Quotation">Quotation</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Done">Done</option>
                                    <option value="Cancel">Cancel</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_assignedBy">{{ trans('cruds.leads.fields.assigned_by') }}</label>
                                <select name="assigned_by" id="edit_assignedBy" class="form-control" required>
                                    <option value="Test 1">Test 1</option>
                                    <option value="Test 2">Test 2</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_source">{{ trans('cruds.leads.fields.source') }}</label>
                                <select name="source" id="edit_source" class="form-control" required>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="Twitter">Twitter (X)</option>
                                    <option value="LinkedIn">LinkedIn</option>
                                    <option value="YouTube">YouTube</option>
                                    <option value="WhatsApp">WhatsApp</option>
                                    <option value="Telegram">Telegram</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_purpose">{{ trans('cruds.leads.fields.purpose') }}</label>
                        <textarea id="edit_purpose" class="form-control" name="purpose" rows="2" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="edit_remarks">{{ trans('cruds.leads.fields.remarks') }}</label>
                        <textarea id="edit_remarks" class="form-control" name="remarks" rows="2"></textarea>
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

<script>
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
        $('#edit_assignedBy').val($(this).data('assigned_by'));
        $('#edit_status').val($(this).data('status'));
        $('#edit_purpose').val($(this).data('purpose'));
        $('#edit_remarks').val($(this).data('remarks'));

        // Fetch selected products via AJAX
        $.ajax({
            url: `/admin/leads/${leadId}/products`,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    let selectedProducts = response.products;
                    $('#product_idss').val(selectedProducts).trigger('change');
                }
            },
            error: function(xhr) {
                console.error("Error fetching products:", xhr.responseText);
            }
        });

        $('#editLeadsModal').modal('show');
    });

    $('#product_idss').select2({
        placeholder: "Select Products",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#editLeadsModal')
    });
</script>
