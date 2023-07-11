@extends('layouts.template')

@push('csslib')
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@push('css')
@endpush

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Data {{ $title }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('product.create') }}" class="btn btn-primary">
                                Add
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <form action="" id="formSelected">
                            <table class="table table-hover" id="table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;">#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Kategori</th>
                                        <th>Supplier</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <th>Berat</th>
                                        <th>Stock</th>
                                        <th>Desc</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ $item->image }}" width="50" alt="Product"></td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->kategori->name }}</td>
                                            <td>{{ $item->supplier->name }}</td>
                                            <td>{{ $item->harga_beli }}</td>
                                            <td>{{ $item->harga_jual }}</td>
                                            <td>{{ $item->berat }}</td>
                                            <td>{{ $item->stock }}</td>
                                            <td>{{ $item->desc }}</td>
                                            <td class="text-center">
                                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                    <a href="{{ route('product.edit', $item->id) }}"
                                                        class="btn btn-sm btn-warning"><i class="far fa-edit"></i></a>
                                                    <button type="button" value="{{ $item->id }}"
                                                        onclick="deleteData('{{ $item->id }}')"
                                                        class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="delete" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection


@push('jslib')
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('js')
    <script>
        var table = $("#table").DataTable({
            columnDefs: [{
                    orderable: false,
                    targets: [10]
                },
                {
                    searchable: false,
                    targets: [10]
                },
            ]

        })

        function deleteData(id) {
            swal({
                title: 'Delete Selected Data?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then(function(result) {
                if (result) {
                    var deleteForm = $('#delete');
                    deleteForm.attr('action', "{{ route('product.destroy', '') }}" + '/' + id);
                    deleteForm.submit();
                    block();
                }
            })
        }
    </script>
@endpush
