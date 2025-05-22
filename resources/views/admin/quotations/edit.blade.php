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
                  <form id="editLeadForm" method="POST" action="{{ route('admin.leads.update', $lead->id) }}">
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
                                  <label for="edit_city">{{ trans('cruds.leads.fields.city') }}</label>
                                  <input type="text" id="edit_city" class="form-control" name="city" required>
                              </div>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="required" for="product_idss">Select Products</label>
                                  <select name="product_ids[]" id="product_idss" class="form-control select2" multiple
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
                                      <option value="Pending">Pending</option>
                                      <option value="Done">Done</option>
                                      <option value="Cancel">Cancel</option>
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
