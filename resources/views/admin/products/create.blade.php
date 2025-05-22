 <!-- Create Products Modal -->
 <div class="modal fade " id="createProductsModal" tabindex="-1" role="dialog" aria-labelledby="createProductsModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="createProductsModalLabel">{{ trans('global.add') }}
                     {{ trans('cruds.products.title_singular') }}</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="{{ route('admin.products.store') }}" method="POST">
                 @csrf



                 <div class="modal-body">
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group ">
                                 <label for="name">{{ trans('cruds.products.fields.name') }}</label>
                                 <input type="text" name="name" class="form-control" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="category_id">Select Category</label>
                                 <select name="category_id" class="form-control" required>
                                     <option value="">{{ trans('global.pleaseSelect') }}</option>
                                     @foreach ($categories as $category)
                                         <option value="{{ $category->id }}">{{ $category->name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="price">{{ trans('cruds.products.fields.product_price') }}</label>
                                 <input type="number" name="price" class="form-control" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="tax">{{ trans('cruds.products.fields.product_tax') }}</label>
                                 <input type="number" name="tax" class="form-control" required>
                             </div>
                         </div>
                     </div>

                     {{-- <div class="form-group">
                         <label for="assigned_name">{{ trans('cruds.products.fields.assigned_name') }}</label>
                         <input type="text" name="assigned_name" class="form-control">
                     </div> --}}


                     <div class="form-group">
                         <label for="description">{{ trans('cruds.products.fields.description') }}</label>
                         <textarea id="description" class="form-control" name="description"></textarea>
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
