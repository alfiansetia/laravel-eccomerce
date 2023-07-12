@extends('layouts.template')
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Add {{ $title }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('payment.index') }}" class="btn btn-primary">
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <form id="form" action="{{ route('payment.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="control-label" for="name">Name :</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    placeholder="Please Enter Name" minlength="3" maxlength="25"
                                    value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="acc_name">Acc Name :</label>
                                <input type="text" name="acc_name"
                                    class="form-control @error('acc_name') is-invalid @enderror" id="acc_name"
                                    placeholder="Please Enter Acc Name" minlength="3" maxlength="25"
                                    value="{{ old('acc_name') }}" required>
                                @error('acc_name')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="acc_number">Acc Number :</label>
                                <input type="text" name="acc_number"
                                    class="form-control @error('acc_number') is-invalid @enderror" id="acc_number"
                                    placeholder="Please Enter Acc Number" minlength="3" maxlength="25"
                                    value="{{ old('acc_number') }}" required>
                                @error('acc_number')
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
@endsection

@push('js')
    <script>
        $('form').submit(function() {
            $('button').prop('disabled', true);
            block();
        })
    </script>
@endpush
