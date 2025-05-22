 <!-- Create Products Modal -->
 <div class="modal fade" id="createProductCategoryModal" tabindex="-1" role="dialog"
     aria-labelledby="createProductsModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="createProductsModalLabel">{{ trans('global.add') }}
                     {{ trans('cruds.productCategory.title_singular') }}</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="{{ route('admin.productCategory.store') }}" method="POST">
                 @csrf
                 <div class="modal-body">
                     <div class="form-group">
                         <label for="name">{{ trans('cruds.productCategory.fields.name') }}</label>
                         <input type="text" name="name" class="form-control" required>
                     </div>

                     <div class="form-group">
                         <label for="description">{{ trans('cruds.productCategory.fields.description') }}</label>
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
