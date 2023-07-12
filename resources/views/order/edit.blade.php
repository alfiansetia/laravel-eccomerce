@extends('layouts.template')
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Edit {{ $title . ' #' . $data->number }} <span
                                class="badge badge-{{ $data->payment_status == 'paid' ? 'success' : 'warning' }}">{{ $data->payment_status }}</span>
                        </h4>
                        <div class="card-header-action">
                            <a href="{{ route('order.index') }}" class="btn btn-primary">
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <form id="form" action="{{ route('order.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="control-label" for="number">Number :</label>
                                <input type="text" name="number"
                                    class="form-control @error('number') is-invalid @enderror" id="number"
                                    placeholder="Please Enter Number" value="{{ $data->number }}" readonly disabled>
                                @error('number')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="date">Date :</label>
                                <input type="text" name="date"
                                    class="form-control @error('date') is-invalid @enderror" id="date"
                                    placeholder="Please Enter Date" value="{{ $data->date }}" readonly disabled>
                                @error('date')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="user">User :</label>
                                <input type="text" name="user"
                                    class="form-control @error('user') is-invalid @enderror" id="user"
                                    placeholder="Please Enter user"
                                    value="{{ $data->user->name }} ({{ $data->user->email }})" readonly disabled>
                                @error('user')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="total">Total :</label>
                                <input type="text" name="total"
                                    class="form-control @error('total') is-invalid @enderror" id="total"
                                    placeholder="Please Enter Total" value="{{ $data->total }}" readonly disabled>
                                @error('total')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="ongkir">Ongkir :</label>
                                <input type="number" name="ongkir"
                                    class="form-control @error('ongkir') is-invalid @enderror" id="ongkir"
                                    placeholder="Please Enter Ongkir" value="{{ $data->ongkir }}" min="0" required>
                                @error('ongkir')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="payment_status">Payment Status :</label>
                                <input type="text" name="payment_status" disabled
                                    class="form-control @error('payment_status') is-invalid @enderror" id="payment_status"
                                    placeholder="Please Enter Payment Status" value="{{ $data->payment_status }}" readonly>
                                @error('payment_status')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="status">Status :</label>
                                <input type="text" name="status"
                                    class="form-control @error('status') is-invalid @enderror" id="status"
                                    placeholder="Please Enter Status" readonly disabled value="{{ $data->status }}">
                                @error('status')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="receipt_name">Receipt Name :</label>
                                <input type="text" name="receipt_name"
                                    class="form-control @error('receipt_name') is-invalid @enderror" id="receipt_name"
                                    placeholder="Please Enter Receipt Name" value="{{ $data->receipt_name }}"
                                    maxlength="30" minlength="3" required>
                                @error('receipt_name')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="receipt_telp">Receipt Telp :</label>
                                <input type="tel" name="receipt_telp"
                                    class="form-control @error('receipt_telp') is-invalid @enderror" id="receipt_telp"
                                    placeholder="Please Enter Receipt Telp" value="{{ $data->receipt_telp }}"
                                    maxlength="15" minlength="8" required>
                                @error('receipt_telp')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="receipt_address">Receipt Address :</label>
                                <textarea name="receipt_address" class="form-control @error('receipt_address') is-invalid @enderror"
                                    id="receipt_address" minlength="5" maxlength="150" required>{{ $data->receipt_address }}</textarea>
                                @error('receipt_address')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="resi">Resi :</label>
                                <textarea name="resi" class="form-control @error('resi') is-invalid @enderror" id="resi" maxlength="100">{{ $data->resi }}</textarea>
                                @error('resi')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="desc">Action :</label>
                                <div class="">
                                    @php
                                        $action = 'confirm_payment';
                                        $text = 'Confirm Payment';
                                        $button = false;
                                        $cancel = false;
                                        if ($data->payment_status == 'paid' || $data->status == 'cancel') {
                                            switch ($data->status) {
                                                case 'waiting':
                                                    $action = 'confirm_process';
                                                    $text = 'Confirm Process';
                                                    $cancel = false;
                                                    break;
                                                case 'on proccess':
                                                    $action = 'confirm_sent';
                                                    $text = 'Confirm Sent';
                                                    $cancel = true;
                                                    break;
                                                case 'sent':
                                                    $action = 'confirm_done';
                                                    $text = 'Confirm Done';
                                                    $cancel = true;
                                                    break;
                                                case 'done':
                                                    $cancel = true;
                                                    $button = true;
                                                    break;
                                                case 'cancel':
                                                    $cancel = true;
                                                    $button = true;
                                                    break;
                                                default:
                                                    break;
                                            }
                                        }
                                    @endphp
                                    <button onclick="setData('{{ $text }}', this.value)" id="action_button"
                                        value="{{ $action }}" type="button" {{ $button ? 'disabled' : '' }}
                                        class="btn btn-primary">{{ $text }}</button>
                                    <button onclick="setData('Confirm Cancel', this.value)" id="cancel_button"
                                        value="confirm_cancel" type="button" class="btn btn-danger"
                                        {{ $cancel ? 'disabled' : '' }}>Confirm Cancel</button>
                                </div>
                                @error('desc')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="reset" id="reset" class="btn btn-warning"><i class="fas fa-undo mr-1"
                                    data-toggle="tooltip" title="Reset"></i>Reset</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane mr-1"
                                    data-toggle="tooltip" title="Save"></i>Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="action" action="{{ route('order.set', $data->id) }}" method="POST">
        @csrf
        <input type="hidden" name="type" id="action_type">
    </form>
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

        // $('#action_button').click(function() {
        //     let val = $(this).val()
        //     setData(val)
        // })

        function setData(text, value) {
            swal({
                title: text + '?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then(function(result) {
                if (result) {
                    $('#action_type').val(value)
                    $('#action').submit();
                    block();
                    // console.log($('#action_type').val());
                }
            })
        }
    </script>
@endpush
