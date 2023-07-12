@extends('layouts.template')
@section('content')
    <div class="section-body">
        <div class="invoice">
            <div class="invoice-print">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="invoice-title">
                            <h2>Invoice</h2>
                            <div class="invoice-number">Order #{{ $data->number }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Billed To:</strong><br>
                                    {{ $data->user->name }}<br>
                                    {{ $data->user->wa }}<br>
                                    {{ $data->user->address }}
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>Shipped To:</strong><br>
                                    {{ $data->receipt_name }}<br>
                                    {{ $data->receipt_telp }}<br>
                                    {{ $data->receipt_address }}
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Payment Method:</strong><br>
                                    {{ $data->payment->name }} {{ $data->payment->acc_number }}<br>
                                    {{ $data->payment->acc_name }}
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>Order Date:</strong><br>
                                    {{ $data->date }}<br><br>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="section-title">Order Summary</div>
                        <p class="section-lead">All items here cannot be deleted.</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-md">
                                <tr>
                                    <th data-width="40">#</th>
                                    <th>Item</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-right">Totals</th>
                                    <th class="text-right">Desc</th>
                                </tr>
                                @forelse ($data->order_detail as $item)
                                    <tr>
                                        <td>1</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td class="text-center">{{ $item->price }}</td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td class="text-right">{{ $item->price * $item->qty }}</td>
                                        <td class="text-right">{{ $item->desc }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="alert alert-danger">No Data </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-7">
                                <div class="section-title">Payment Method</div>
                                <p class="section-lead">The payment method that we provide is to make it easier for you
                                    to pay invoices.</p>
                                <div class="d-flex">
                                    <div class="mr-2 bg-visa" data-width="61" data-height="38"></div>
                                    <div class="mr-2 bg-jcb" data-width="61" data-height="38"></div>
                                    <div class="mr-2 bg-mastercard" data-width="61" data-height="38"></div>
                                    <div class="bg-paypal" data-width="61" data-height="38"></div>
                                </div>
                            </div>
                            <div class="col-lg-5 text-right">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Subtotal</div>
                                    <div class="invoice-detail-value">{{ $data->total }}</div>
                                </div>
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Ongkir</div>
                                    <div class="invoice-detail-value">{{ $data->ongkir }}</div>
                                </div>
                                <hr class="mt-2 mb-2">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Total</div>
                                    <div class="invoice-detail-value invoice-detail-value-lg">
                                        {{ $data->total + $data->ongkir }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-md-right">
                <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @error('type')
        <script>
            swal("Error", "{{ $message }}", 'error');
        </script>
    @enderror
    <script>
        $('form').submit(function() {
            $('button').prop('disabled', true);
            block();
        })
    </script>
@endpush
