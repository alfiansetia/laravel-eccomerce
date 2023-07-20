@extends('layouts.template')

@push('csslib')
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@push('css')
@endpush

@section('content')
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12">
            <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-lg-8 bg-secondary">
                            <form action="{{ route('checkout.save') }}" method="POST">
                                @csrf
                                <div class="p-5">
                                    <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                                    <hr class="my-4">
                                    <h5 class="text-uppercase mb-2">Service</h5>
                                    <div class="mb-2 pb-2">
                                        <input type="hidden" name="courier" id="courier" value="">
                                        <input type="hidden" name="ongkir" id="ongkir" value="">
                                        <select class="form-control" name="service" id="service" required>
                                            <option value="">Select Service</option>
                                            @forelse ($data['rajaongkir']['results'] as $item)
                                                @forelse ($item['costs'] as $value)
                                                    <option data-ongkir="{{ $value['cost'][0]['value'] }}"
                                                        data-courier="{{ $item['code'] }}" value="{{ $value['service'] }}">
                                                        {{ $item['code'] }}
                                                        {{ $value['service'] }}
                                                        {{ $value['cost'][0]['value'] }}</option>
                                                @empty
                                                @endforelse
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <h5 class="text-uppercase mb-2">Payment</h5>
                                    <div class="mb-2 pb-2">
                                        <select class="form-control" name="payment" id="payment" required>
                                            <option value="">Select Payment</option>
                                            @foreach ($payment as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                    {{ $item->acc_name }} {{ $item->acc_number }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <h5 class="text-uppercase">Ongkir</h5>
                                        <h5 id="ongkir_text">0</h5>
                                    </div>
                                    <div class="d-flex justify-content-between mb-5">
                                        <h5 class="text-uppercase">Total</h5>
                                        <h5 id="total_price">{{ $total }}</h5>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block btn-lg">Process</button>
                                </div>
                            </form>
                        </div>
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

        $('#service').change(function() {
            let selectedOption = $(this).find(':selected');
            let ongkir = selectedOption.data('ongkir') ?? 0
            let courier = selectedOption.data('courier')
            $("#courier").val(courier)
            $("#ongkir").val(ongkir)
            $("#ongkir_text").text(ongkir)
            $("#total_price").text(ongkir + parseInt("{{ $total }}"))
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
