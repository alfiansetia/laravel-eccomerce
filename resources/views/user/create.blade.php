@extends('layouts.template')

@push('csslib')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Add {{ $title }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('user.index') }}" class="btn btn-primary">
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <form id="form" action="{{ route('user.store') }}" method="POST">
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
                                <label class="control-label" for="email">Email :</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                    placeholder="Please Enter Email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="wa">WA :</label>
                                <input type="tel" name="wa" class="form-control @error('wa') is-invalid @enderror"
                                    id="wa" placeholder="Please Enter WA" maxlength="15" value="{{ old('wa') }}"
                                    required>
                                @error('wa')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password :</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" id="password"
                                    placeholder="Please Enter Password" minlength="5" value="{{ old('password') }}"
                                    required autocomplete="off">
                                @error('password')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="role">Role :</label>
                                <select name="role" id="role"
                                    class="form-control select2 @error('role') is-invalid @enderror" required>
                                    <option value="">Select Role</option>
                                    <option {{ old('role') == 'admin' ? 'selected' : '' }} value="admin">Admin</option>
                                    <option {{ old('role') == 'user' ? 'selected' : '' }} value="user">User</option>
                                </select>
                                @error('role')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="ship_name">Ship Name :</label>
                                <input type="text" name="ship_name"
                                    class="form-control @error('ship_name') is-invalid @enderror" id="ship_name"
                                    placeholder="Please Enter Ship Name" minlength="3" maxlength="25"
                                    value="{{ old('ship_name') }}">
                                @error('ship_name')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="ship_telp">Ship Telp :</label>
                                <input type="tel" name="ship_telp"
                                    class="form-control @error('ship_telp') is-invalid @enderror" id="ship_telp"
                                    placeholder="Please Enter Ship Telp" maxlength="15" value="{{ old('ship_telp') }}">
                                @error('ship_telp')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="kota">Kota :</label>
                                <select name="kota" id="kota" style="width: 100%"
                                    class="form-control select2 @error('kota') is-invalid @enderror" required>
                                    <option value="">Select Kota</option>
                                    @foreach ($kota as $item)
                                        <option {{ old('kota') == $item->id ? 'selected' : '' }}
                                            value="{{ $item->id }}">{{ $item->name }} {{ $item->province->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kota')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="address">Ship Address :</label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" maxlength="150">{{ old('address') }}</textarea>
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
@push('jslib')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
@endpush

@push('js')
    <script>
        if (jQuery().select2) {
            $(".select2").select2();
        }

        $('button[type=reset]').click(function() {
            $('.select2').val('').change()
        })

        $('form').submit(function() {
            $('button').prop('disabled', true);
            block();
        })
    </script>
@endpush
