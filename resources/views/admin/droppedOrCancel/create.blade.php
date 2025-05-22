<div class="modal fade bd-example-modal-lg" id="createLeadsModal" tabindex="-1" role="dialog"
    aria-labelledby="createLeadsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createLeadsModalLabel">{{ trans('global.add') }}
                    {{ trans('cruds.leads.title_singular') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.leads.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">{{ trans('cruds.leads.fields.name') }}</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobile">{{ trans('cruds.leads.fields.mobile') }}</label>
                                <input type="text" name="mobile" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">{{ trans('cruds.leads.fields.email') }}</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">{{ trans('cruds.leads.fields.address') }}</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product_ids">Select Products </label>
                                <select name="product_ids[]" id="product_ids" class="form-control select2" multiple
                                    required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="assigned_name">Assigned Name</label>
                                <select name="assigned_name" class="form-control">
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
                                <label for="status">{{ trans('cruds.leads.fields.status') }}</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="New">New</option>
                                    <option value="Qualified">Qualified</option>
                                    <option value="Flowup">Flowup</option>
                                    <option value="Demo">Demo</option>
                                    <option value="Quotation / Ready To Buy">Quotation / Ready To Buy</option>
                                    <option value="Closed or Won">Closed or Won</option>
                                    <option value="Dropped or Cancel">Dropped or Cancel</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="source">{{ trans('cruds.leads.fields.source') }}</label>
                                <select name="source" id="source" class="form-control" required>
                                    <option value="">{{ trans('global.pleaseSelect') }}</option>
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
                        <label for="purpose">{{ trans('cruds.leads.fields.purpose') }}</label>
                        <textarea name="purpose" id="purpose" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="remarks">{{ trans('cruds.leads.fields.remarks') }}</label>
                        <textarea name="remarks" id="remarks" class="form-control" rows="2"></textarea>
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
@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#product_ids').select2({
                placeholder: "Select Products",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#createLeadsModal')
            });



        });
    </script>
@endsection
