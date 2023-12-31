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
                        <h4>Edit {{ $title . ' ' . $data->name }} </h4>
                        <div class="card-header-action">
                            <a href="{{ route('kota.index') }}" class="btn btn-primary">
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <form id="form" action="{{ route('kota.update', $data->id) }}" method="POST">
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
                                <label class="control-label" for="province">Province :</label>
                                <select name="province" id="province" style="width: 100%"
                                    class="form-control select2 @error('province') is-invalid @enderror" required>
                                    <option value="">Select Province</option>
                                    @foreach ($province as $item)
                                        <option {{ $data->province_id == $item->id ? 'selected' : '' }}
                                            value="{{ $item->id }}">{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('province')
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
            $('#province').val('{{ $data->province_id }}').change()
        })

        $('form').submit(function() {
            $('button').prop('disabled', true);
            block();
        })
    </script>
@endpush
