@extends('layouts.admin')
@section('title', __('cruds.products.title_singular'))
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

    @if(session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
    <div class="card">
        <div class="card-header">



            <div class="row align-items-center">
                <div class="col-lg-10 col-sm-10 col-md-10 col-xs-12">
                    <h5> {{ trans('cruds.products.title_singular') }} {{ trans('global.list') }}</h5>
                </div>
                &nbsp;&nbsp;
                <button class="btn btn-success" data-toggle="modal" data-target="#createProductsModal">
                   + {{ trans('cruds.products.title_singular') }}
                </button>

                 &nbsp;&nbsp;
                <a class="btn btn-sm btn-success" href="{{ route('admin.products.bulk-import') }}"
                style="float:right; margin-right: 2px;" title="{{ trans('global.bulk_import') }}">
                       Import <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                    </a>

            </div>

        </div>


        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Products">
                    <thead>
                        <tr>
                            <th>
                                {{ trans('cruds.products.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.products.fields.name') }}
                            </th>
                            <th>
                                {{ trans('cruds.products.fields.productCategory') }}
                            </th>
                            <th>
                                {{ trans('cruds.products.fields.description') }}
                            </th>

                            <th>
                                {{ trans('cruds.products.fields.created_at') }}
                            </th>
                            <th>
                                {{ trans('cruds.products.fields.action') }}
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
                        @foreach ($products as $key => $product)
                            <tr data-entry-id="{{ $product->id }}">
                                <td>
                                    {{ $product->id ?? '' }}
                                </td>
                                <td>
                                    {{ $product->name ?? '' }}
                                </td>

                                <td>
                                    {{ $product->category->name ?? '' }}
                                </td>

                                <td>
                                    {{-- {{ $product->description ?? '' }} --}}
                                    {{ \Illuminate\Support\Str::words($product->description, 5, '...') }}
                                </td>
                                <td>
                                    {{ optional(\Carbon\Carbon::parse($product->created_at))->format('d-m-Y g:i A') ?? '' }}
                                </td>
                                <td>


                                    <a class="btn btn-xs btn-primary view-product" href="#"
                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                        data-category="{{ $product->category->name ?? 'N/A' }}"
                                        data-description="{{ $product->description }}" data-price="{{ $product->price }}"
                                        data-tax="{{ $product->tax }}"
                                        data-created_at="{{ optional(\Carbon\Carbon::parse($product->created_at))->format('d-m-Y g:i A') ?? '' }}"
                                        data-toggle="modal" data-target="#viewProductModal">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a class="btn btn-xs btn-warning edit-products" href="#"
                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                        data-category="{{ $product->category->id ?? '' }}"
                                        data-description="{{ $product->description }}" data-price="{{ $product->price }}"
                                        data-tax="{{ $product->tax }}" data-toggle="modal"
                                        data-target="#editViewProductModal">
                                        <i class="fa fa-edit"></i>
                                    </a>




                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
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
    @include('admin.products.create')
    <!-- Edit Contact Modal -->

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editViewProductModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('global.edit') }} {{ trans('cruds.products.title_singular') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="editViewProductForm" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" id="edit_id" name="id">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_name">{{ trans('cruds.products.fields.name') }}</label>
                                    <input type="text" id="edit_name" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_category">Select Category</label>
                                    <select id="edit_category" name="category_id" class="form-control" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_price">{{ trans('cruds.products.fields.product_price') }}</label>
                                    <input type="number" id="edit_price" class="form-control" name="price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_tax">{{ trans('cruds.products.fields.product_tax') }}</label>
                                    <input type="number" id="edit_tax" class="form-control" name="tax" required>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="edit_description">{{ trans('cruds.products.fields.description') }}</label>
                            <textarea id="edit_description" class="form-control" name="description"></textarea>
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

    <!-- View Contact Modal -->
    <div class="modal fade" id="viewProductModal" tabindex="-1" role="dialog" aria-labelledby="viewProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewProductModalLabel">{{ trans('global.view') }}
                        {{ trans('cruds.products.title_singular') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>{{ trans('cruds.products.fields.id') }}</th>
                                <td id="viewId"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.products.fields.name') }}</th>
                                <td id="viewName"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.products.fields.productCategory') }}</th>
                                <td id="viewCategory"></td> <!-- Added Category -->
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.products.fields.product_price') }}</th>
                                <td id="viewPrice"></td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.products.fields.product_tax') }}</th>
                                <td id="viewTax"></td>
                            </tr>

                            <tr>
                                <th>{{ trans('cruds.products.fields.description') }}</th>
                                <td id="viewDescription"></td>
                            </tr>

                            <tr>
                                <th>{{ trans('cruds.products.fields.created_at') }}</th>
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
            let table = $('.datatable-Products:not(.ajaxTable)').DataTable({
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
            $('.edit-products').on('click', function() {
                let productId = $(this).data('id');
                let productName = $(this).data('name');
                let productDescription = $(this).data('description');
                let productCategory = $(this).data('category'); // Fetch category ID
                let productPrice = $(this).data('price');
                let productTax = $(this).data('tax');
                // let productAssignedName = $(this).data('assigned_name');

                // Update form action dynamically
                $('#editViewProductForm').attr('action', '/admin/products/' + productId);

                // Populate form fields
                $('#edit_name').val(productName);
                $('#edit_description').val(productDescription);
                $('#edit_category').val(productCategory); // Set the category value in the dropdown
                $('#edit_price').val(productPrice);
                $('#edit_tax').val(productTax);
                // $('#edit_assigned_name').val(productAssignedName);

                // Show the modal
                $('#editViewProductModal').modal('show');
            });

            // view product
            $('.view-product').on('click', function() {
                $('#viewId').text($(this).data('id'));
                $('#viewName').text($(this).data('name'));
                $('#viewCategory').text($(this).data('category'));
                $('#viewDescription').text($(this).data('description'));
                $('#viewPrice').text($(this).data('price'));
                $('#viewTax').text($(this).data('tax'));
                // $('#viewAssignedName').text($(this).data('assigned_name'));
                $('#viewCreatedAt').text($(this).data('created_at'));

                $('#viewProductModal').modal('show');
            });


        });
    </script>
@endsection
