@extends('layouts.admin')
@section('title', __('cruds.contact.title_singular'))
@section('content')
    <p>&nbsp;</p>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-lg-10 col-sm-10 col-md-10 col-xs-12">
                    <h5> {{ trans('cruds.contact.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <button class="btn btn-success" data-toggle="modal" data-target="#createContactModal">
                    {{ trans('global.add') }} {{ trans('cruds.contact.title_singular') }}
                </button>
            </div>

        </div>


        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Contact">
                    <thead>
                        <tr>
                            <th>{{ trans('cruds.contact.fields.id') }}</th>
                            <th>
                                {{ trans('cruds.contact.fields.name') }}
                            </th>
                            <th>
                                {{ trans('cruds.contact.fields.phone') }}
                            </th>
                            <th>
                                {{ trans('cruds.contact.fields.email') }}
                            </th>
                            <th>
                                {{ trans('cruds.contact.fields.created_at') }}
                            </th>
                            <th>
                                {{ trans('cruds.contact.fields.action') }}
                            </th>
                        </tr>
                        {{-- <tr>
                            <td>
                                <input class="search" type="text" placeholder>
                            <td>
                                <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                            </td>
                        </tr> --}}
                    </thead>
                    <tbody>
                        @foreach ($contacts as $key => $contact)
                            <tr data-entry-id="{{ $contact->id }}">
                                <td>
                                    {{ $contact->id ?? '' }}
                                <td>
                                    {{ $contact->name ?? '' }}
                                </td>
                                <td>
                                    {{ $contact->phone ?? '' }}
                                </td>
                                <td>
                                    {{ $contact->email ?? '' }}
                                </td>
                                <td>
                                    {{ optional(\Carbon\Carbon::parse($contact->created_at))->format('d-m-Y g:i A') ?? '' }}
                                </td>
                                <td>


                                    <a class="btn btn-xs btn-primary view-contact" href="#"
                                        data-id="{{ $contact->id }}" data-name="{{ $contact->name }}"
                                        data-phone="{{ $contact->phone }}" data-email="{{ $contact->email }}"
                                        data-message="{{ $contact->message ?? '' }}"
                                        data-created_at="{{ optional(\Carbon\Carbon::parse($contact->created_at))->format('d-m-Y g:i A') ?? '' }}"
                                        data-toggle="modal" data-target="#viewContactModal">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a class="btn btn-xs btn-warning edit-contact" href="#"
                                        data-id="{{ $contact->id }}" data-name="{{ $contact->name }}"
                                        data-phone="{{ $contact->phone }}" data-email="{{ $contact->email }}"
                                        data-message="{{ $contact->message ?? '' }}"
                                        data-created_at="{{ optional(\Carbon\Carbon::parse($contact->created_at))->format('d-m-Y g:i A') ?? '' }}"
                                        data-toggle="modal" data-target="#editViewContactModal">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    @can('contact_delete')
                                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-xs btn-danger"
                                                title="{{ trans('global.delete') }}">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    @endcan


                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Contact Modal -->
    @include('admin.contacts.create')
    <!-- Edit Contact Modal -->


    {{-- edit model --}}
    <!-- Edit Contact Modal -->
    <div class="modal fade" id="editViewContactModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('global.edit') }}
                        {{ trans('cruds.contact.title_singular') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="editViewContactForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="edit_name">{{ trans('cruds.contact.fields.name') }}</label>
                            <input type="text" id="edit_name" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_phone">{{ trans('cruds.contact.fields.phone') }}</label>
                            <input type="text" id="edit_phone" class="form-control" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_email">{{ trans('cruds.contact.fields.email') }}</label>
                            <input type="email" id="edit_email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_message">{{ trans('cruds.contact.fields.message') }}</label>
                            <textarea id="edit_message" class="form-control" name="message" required></textarea>
                        </div>

                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('global.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('global.save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Contact Modal -->
    <!-- View Contact Modal -->
    <div class="modal fade" id="viewContactModal" tabindex="-1" role="dialog" aria-labelledby="viewContactModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewContactModalLabel">{{ trans('global.view') }}
                        {{ trans('cruds.contact.title_singular') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>{{ trans('cruds.contact.fields.id') }}</th>
                                <td id="viewId"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.contact.fields.name') }}</th>
                                <td id="viewName"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.contact.fields.phone') }}</th>
                                <td id="viewPhone"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.contact.fields.email') }}</th>
                                <td id="viewEmail"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.contact.fields.message') }}</th>
                                <td id="viewMessage"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.contact.fields.created_at') }}</th>
                                <td id="viewCreatedAt"></td>
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




@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-Contact:not(.ajaxTable)').DataTable({
                buttons: dtButtons,
                order: [[0, 'desc']]
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            let visibleColumnsIndexes = null;
            $('.datatable thead').on('input', '.search', function() {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value

                let index = $(this).parent().index()
                if (visibleColumnsIndexes !== null) {
                    index = visibleColumnsIndexes[index]
                }

                table
                    .column(index)
                    .search(value, strict)
                    .draw()
            });
            table.on('column-visibility.dt', function(e, settings, column, state) {
                visibleColumnsIndexes = []
                table.columns(":visible").every(function(colIdx) {
                    visibleColumnsIndexes.push(colIdx);
                });
            })
        })

        // model form

        $(document).ready(function() {
            $('.edit-contact').on('click', function() {
                let contactId = $(this).data('id');
                let contactName = $(this).data('name');
                let contactPhone = $(this).data('phone');
                let contactEmail = $(this).data('email');
                let contactMessage = $(this).data('message');

                $('#editViewContactForm').attr('action', '/admin/contacts/' + contactId);
                $('#edit_name').val(contactName);
                $('#edit_phone').val(contactPhone);
                $('#edit_email').val(contactEmail);
                $('#edit_message').val(contactMessage);

                $('#editViewContactModal').modal('show');
            });

            $('.view-contact').on('click', function() {
                let contactName = $(this).data('name');
                let contactPhone = $(this).data('phone');
                let contactEmail = $(this).data('email');
                let contactMessage = $(this).data('message');
                let contactCreatedAt = $(this).data('created_at');

                $('#viewName').text(contactName);
                $('#viewPhone').text(contactPhone);
                $('#viewEmail').text(contactEmail);
                $('#viewMessage').text(contactMessage);
                $('#viewCreatedAt').text(contactCreatedAt);

                $('#viewContactModal').modal('show');
            });


        });
    </script>
@endsection
