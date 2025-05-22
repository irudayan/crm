<!-- Create Leads Modal -->
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
                                <label for="city">{{ trans('cruds.leads.fields.city') }}</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="required" for="product_ids">Select Products</label>
                                <select class="form-control select2" name="product_ids[]" id="product_ids" multiple
                                    required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">{{ trans('cruds.leads.fields.status') }}</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="Pending">pending</option>
                                    <option value="Done">done</option>
                                    <option value="Cancel">cancel</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="purpose">{{ trans('cruds.leads.fields.purpose') }}</label>
                        <textarea name="purpose" id="purpose" class="form-control" rows="2" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="remarks">{{ trans('cruds.leads.fields.remarks') }}</label>
                        <textarea name="remarks" id="remarks" class="form-control" rows="2" required></textarea>
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
            $('#product_ids').select2({
                placeholder: "Select Products",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection
