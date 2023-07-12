@extends('layouts.template')
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Edit {{ $title . ' ' . $data->name }} </h4>
                        <div class="card-header-action">
                            <a href="{{ route('supplier.index') }}" class="btn btn-primary">
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <form id="form" action="{{ route('supplier.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="control-label" for="name">Name :</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    placeholder="Please Enter Name" minlength="3" maxlength="25"
                                    value="{{ $data->name }}" required autofocus>
                                @error('name')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="telp">Telp :</label>
                                <input type="tel" name="telp"
                                    class="form-control @error('telp') is-invalid @enderror" id="telp"
                                    placeholder="Please Enter Telp" maxlength="15" value="{{ $data->telp }}">
                                @error('telp')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="address">Address :</label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address">{{ $data->address }}</textarea>
                                @error('address')
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
