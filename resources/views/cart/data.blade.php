@extends('layouts.template')

@push('csslib')
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@push('css')
@endpush

@section('content')
    @php
        $disable_checkout = false;
    @endphp
    @if (empty(auth()->user()->address) ||
            empty(auth()->user()->kota_id) ||
            empty(auth()->user()->ship_name) ||
            empty(auth()->user()->ship_telp))
        @php
            $disable_checkout = true;
        @endphp
        <div class="alert alert-danger alert-has-icon">
            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
            <div class="alert-body">
                <div class="alert-title">Incomplete Profile!</div>
                Complete your profile to continue, <a href="{{ route('user.ship') }}">Click Here!</a>
            </div>
        </div>
    @endif
    @php
        if (count($data) < 1) {
            $disable_checkout = true;
        }
    @endphp
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12">
            <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-lg-8">
                            <div class="p-5">
                                <div class="d-flex justify-content-between align-items-center mb-5">
                                    <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                                    <h6 class="mb-0 text-muted">{{ count($data) }} items</h6>
                                </div>
                                <hr class="my-4">
                                @php
                                    $total = 0;
                                @endphp

                                @forelse ($data as $item)
                                    @php
                                        $total = $total + $item->product->harga_jual * $item->total;
                                    @endphp
                                    <div class="row mb-4 d-flex justify-content-between align-items-center">
                                        <div class="col-md-2 col-lg-2 col-xl-2">
                                            <img src="{{ $item->product->image }}" class="img-fluid rounded-3"
                                                alt="{{ $item->product->name }}">
                                        </div>
                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                            <h6 class="text-muted">{{ $item->product->kategori->name }}</h6>
                                            <h6 class="text-black mb-0">{{ $item->product->name }}</h6>
                                        </div>
                                        <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                            <button class="btn btn-link px-2"
                                                onclick="this.parentNode.querySelector('input[type=number]').stepDown();changeData(this.parentNode.querySelector('input[type=number]'));">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <input id="form1" min="1" name="quantity" value="{{ $item->total }}"
                                                type="number" class="form-control total_item" style="width: 80px"
                                                onchange="updateData(this.value, '{{ $item->id }}')" />

                                            <button class="btn btn-link px-2"
                                                onclick="this.parentNode.querySelector('input[type=number]').stepUp();changeData(this.parentNode.querySelector('input[type=number]'));">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                            <h6 class="mb-0">{{ $item->product->harga_jual * $item->total }}</h6>
                                        </div>
                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="fas fa-times"></i></button>
                                            </form>
                                        </div>
                                    </div>

                                    <hr class="my-4">
                                @empty
                                    <div class="alert alert-danger">Cart Empty</div>
                                @endforelse

                                <div class="pt-5">
                                    <h6 class="mb-0">
                                        <a href="{{ route('home') }}" class="text-body">
                                            <i class="fas fa-long-arrow-alt-left mr-2"></i>Back to shop
                                        </a>
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 bg-secondary">
                            <form action="{{ route('checkout') }}" method="GET">
                                <div class="p-5">
                                    <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                                    <hr class="my-4">

                                    <div class="d-flex justify-content-between mb-2">
                                        <h5 class="text-uppercase">items {{ count($data) }}</h5>
                                        <h5>Rp {{ $total }}</h5>
                                    </div>
                                    <h5 class="text-uppercase mb-2">Courier</h5>
                                    <div class="mb-2 pb-2">
                                        <select class="form-control" name="courier" id="courier" required>
                                            <option value="">Select Courir</option>
                                            <option {{ old('courier') == 'jne' ? 'selected' : '' }} value="jne">jne
                                            </option>
                                            <option {{ old('courier') == 'tiki' ? 'selected' : '' }} value="tiki">tiki
                                            </option>
                                            <option {{ old('courier') == 'pos' ? 'selected' : '' }} value="pos">pos
                                            </option>
                                        </select>
                                    </div>
                                    <h5 class="text-uppercase mb-2">Ship To</h5>
                                    <div class="mb-2 pb-2">
                                        <textarea name="address" class="form-control" id="address" disabled>{{ auth()->user()->ship_name . ' (' . auth()->user()->ship_telp . ')' . PHP_EOL . auth()->user()->address . ', ' . (auth()->user()->kota->name ?? '') . ', ' . (auth()->user()->kota->province->name ?? '') }}</textarea>
                                        <label class="form-label mt-1" for="address">Edit shipping address from your
                                            <a href="{{ route('user.profile') }}">profile</a></label>
                                    </div>
                                    <div class="d-flex justify-content-between mb-5">
                                        <h5 class="text-uppercase">Total price</h5>
                                        <h5>{{ $total }}</h5>
                                    </div>

                                    <button {{ $disable_checkout ? 'disabled' : '' }} type="submit"
                                        class="btn btn-primary btn-block btn-lg"
                                        onclick="console.log('otw')">Checkout</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Data {{ $title }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('home') }}" class="btn btn-primary">
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
                                        <th>Product</th>
                                        <th>Total</th>
                                        <th>Desc</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->total }}</td>
                                            <td>{{ $item->desc }}</td>
                                            <td class="text-center">
                                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                    <a href="{{ route('supplier.edit', $item->id) }}"
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
    </div> --}}

    <form id="update" action="" method="POST" style="display: none;">
        @csrf
        @method('PUT')
        <input type="hidden" name="total" id="total">
    </form>
@endsection


@push('jslib')
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('js')
    @error('courier')
        <script>
            swal("Error", "{{ $message }}", 'error');
        </script>
    @enderror
    <script>
        $('form').submit(function() {
            $('button').prop('disabled', true);
            block();
        })

        $('#tes').change(function() {
            let val = $(this).val()
            console.log(val);
            $.get("{{ route('cek.ongkir') }}", {
                "weight": 1000,
                "courier": val
            }).done(function(res) {
                console.log(res.length)
                if (res.length < 1) {
                    alert('no opt')
                } else {
                    for (let i = 0; i < res[0].costs.length; i++) {
                        console.log(res[0].costs[i]['service']);
                        let opt = new Option(res[0].costs[i]['service'], res[0].costs[i]['service']);
                        $('#tes2').append(opt)
                    }
                }
            }).fail(function(xhr) {
                console.log(xhr)
            })
        })

        function changeData(elemen) {
            $(elemen).change()
        }


        function updateData(value, id) {
            var updateForm = $('#update');
            $('#total').val(value)
            updateForm.attr('action', "{{ route('cart.update', '') }}" + '/' + id);
            updateForm.submit();
            block();
        }
    </script>
@endpush
