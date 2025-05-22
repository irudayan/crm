@extends('layouts.admin')
@section('title', __('cruds.productCategory.title_singular'))
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
                    <h5> {{ trans('cruds.productCategory.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <button class="btn btn-success" data-toggle="modal" data-target="#createProductCategoryModal">
                    {{ trans('global.add') }} {{ trans('cruds.productCategory.title_singular') }}
                </button>
            </div>

        </div>


        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-ProductCategory">
                    <thead>
                        <tr>
                            <th>
                                {{ trans('cruds.productCategory.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.productCategory.fields.name') }}
                            </th>
                            <th>
                                {{ trans('cruds.productCategory.fields.description') }}
                            </th>

                            <th>
                                {{ trans('cruds.productCategory.fields.created_at') }}
                            </th>
                            <th>
                                {{ trans('cruds.productCategory.fields.action') }}
                            </th>
                        </tr>
                        {{-- <tr>
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
                        @foreach ($productCategory as $key => $product)
                            <tr data-entry-id="{{ $product->id }}">
                                <td>
                                    {{ $product->id ?? '' }}
                                </td>
                                <td>
                                    {{ $product->name ?? '' }}
                                </td>
                                <td>
                                    {{ $product->description ?? '' }}
                                </td>
                                <td>
                                    {{ optional(\Carbon\Carbon::parse($product->created_at))->format('d-m-Y g:i A') ?? '' }}
                                </td>
                                <td>


                                    <a class="btn btn-xs btn-primary view-productCategory" href="#"
                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                        data-description="{{ $product->description }}"
                                        data-created_at="{{ optional(\Carbon\Carbon::parse($product->created_at))->format('d-m-Y g:i A') ?? '' }}"
                                        data-toggle="modal" data-target="#viewProductCategoryModal">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a class="btn btn-xs btn-warning edit-productCategory" href="#"
                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                        data-description="{{ $product->description }}" data-toggle="modal"
                                        data-target="#editProductCategoryModal">
                                        <i class="fa fa-edit"></i>
                                    </a>




                                    <form action="{{ route('admin.productCategory.destroy', $product->id) }}"
                                        method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                        style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-xs btn-danger"
                                            title="{{ trans('global.delete') }}">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </form>


                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Contact Modal -->
    @include('admin.productCategory.create')
    <!-- Edit Contact Modal -->


    <!-- Edit Contact Modal -->
    <div class="modal fade" id="editProductCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('global.edit') }}
                        {{ trans('cruds.productCategory.title_singular') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="editViewProductForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="edit_name">{{ trans('cruds.productCategory.fields.name') }}</label>
                            <input type="text" id="edit_name" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">{{ trans('cruds.productCategory.fields.description') }}</label>
                            <input type="text" id="edit_description" class="form-control" name="description" required>
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
    <div class="modal fade" id="viewProductCategoryModal" tabindex="-1" role="dialog"
        aria-labelledby="viewProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewProductCategoryModalLabel">{{ trans('global.view') }}
                        {{ trans('cruds.productCategory.title_singular') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>{{ trans('cruds.productCategory.fields.id') }}</th>
                                <td id="viewId"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.productCategory.fields.name') }}</th>
                                <td id="viewName"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.productCategory.fields.description') }}</th>
                                <td id="viewDescription"></td>
                            </tr>

                            <tr>
                                <th>{{ trans('cruds.productCategory.fields.created_at') }}</th>
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
            let table = $('.datatable-ProductCategory:not(.ajaxTable)').DataTable({
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
            $('.edit-productCategory').on('click', function() {
                let productId = $(this).data('id');
                let productName = $(this).data('name');
                let productDescription = $(this).data('description'); // Ensure this matches the HTML button

                // Update form action dynamically
                $('#editViewProductForm').attr('action', '/admin/productCategory/' + productId);

                // Populate form fields
                $('#edit_name').val(productName);
                $('#edit_description').val(productDescription);

                // Show the modal
                $('#editProductCategoryModal').modal('show');
            });

            // view product
            $('.view-productCategory').on('click', function() {
                let productId = $(this).data('id');
                let productName = $(this).data('name');
                let productDescription = $(this).data('description');
                let productCreatedAt = $(this).data('created_at');

                // Assign values to modal fields
                $('#viewId').text(productId);
                $('#viewName').text(productName);
                $('#viewDescription').text(productDescription); // Corrected ID
                $('#viewCreatedAt').text(productCreatedAt);

                // Show the modal
                $('#viewProductCategoryModal').modal('show');
            });


        });
    </script>
@endsection
