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
                        <h4>{{ $title }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('user.create') }}" class="btn btn-primary">
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>WA</th>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->wa }}</td>
                                            <td class="text-center">{{ $item->role }}</td>
                                            <td class="text-center">
                                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                    <a href="{{ route('user.edit', $item->id) }}"
                                                        class="btn btn-sm btn-warning"><i class="far fa-edit"></i></a>
                                                    <form id="{{ 'form' . $item->id }}"
                                                        action="{{ route('user.destroy', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" value="{{ $item->id }}"
                                                            onclick="deleteData(this)" class="btn btn-sm btn-danger"><i
                                                                class="fas fa-trash"></i></button>
                                                    </form>
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
                    targets: [5]
                },
                {
                    searchable: false,
                    targets: [5]
                },
            ]

        })

        function deleteData(button) {
            let id = $(button).val()
            swal({
                title: 'Delete Selected Data?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then(function(result) {
                if (result) {
                    $('#form' + id).submit()
                }
            })
        }
    </script>
@endpush
