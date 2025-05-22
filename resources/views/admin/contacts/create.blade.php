 <!-- Create Contact Modal -->
 <div class="modal fade" id="createContactModal" tabindex="-1" role="dialog" aria-labelledby="createContactModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="createContactModalLabel">{{ trans('global.add') }}
                     {{ trans('cruds.contact.title_singular') }}</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="{{ route('admin.contacts.store') }}" method="POST">
                 @csrf
                 <div class="modal-body">
                     <div class="form-group">
                         <label for="name">{{ trans('cruds.contact.fields.name') }}</label>
                         <input type="text" name="name" class="form-control" required>
                     </div>
                     <div class="form-group">
                         <label for="phone">{{ trans('cruds.contact.fields.phone') }}</label>
                         <input type="text" name="phone" class="form-control" required>
                     </div>
                     <div class="form-group">
                         <label for="email">{{ trans('cruds.contact.fields.email') }}</label>
                         <input type="email" name="email" class="form-control" required>
                     </div>
                     <div class="form-group">
                         <label for="message">{{ trans('cruds.contact.fields.message') }}</label>
                         <textarea id="message" class="form-control" name="message"></textarea>
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
