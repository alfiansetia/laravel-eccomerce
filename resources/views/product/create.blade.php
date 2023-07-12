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
                            <a href="{{ route('product.index') }}" class="btn btn-primary">
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <form id="form" action="{{ route('product.store') }}" method="POST"
                            enctype="multipart/form-data">
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
                                <label class="control-label" for="kategori">Kategori :</label>
                                <select name="kategori" id="kategori" style="width: 100%"
                                    class="form-control select2 @error('kategori') is-invalid @enderror" required>
                                    <option value="">Select Kategori</option>
                                    @foreach ($kategori as $item)
                                        <option {{ old('kategori') == $item->id ? 'selected' : '' }}
                                            value="{{ $item->id }}">{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="supplier">Supplier :</label>
                                <select name="supplier" id="supplier" style="width: 100%"
                                    class="form-control select2 @error('supplier') is-invalid @enderror" required>
                                    <option value="">Select Supplier</option>
                                    @foreach ($supplier as $item)
                                        <option {{ old('supplier') == $item->id ? 'selected' : '' }}
                                            value="{{ $item->id }}">{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="harga_beli">Harga Beli :</label>
                                <input type="number" name="harga_beli"
                                    class="form-control @error('harga_beli') is-invalid @enderror" id="harga_beli"
                                    placeholder="Please Enter Harga Beli" min="0" value="{{ old('harga_beli') }}">
                                @error('harga_beli')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="harga_jual">Harga Jual :</label>
                                <input type="number" name="harga_jual"
                                    class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual"
                                    placeholder="Please Enter Harga Jual" min="0" value="{{ old('harga_jual') }}">
                                @error('harga_jual')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="berat">Berat (gr) :</label>
                                <input type="number" name="berat"
                                    class="form-control @error('berat') is-invalid @enderror" id="berat"
                                    placeholder="Please Enter Berat" min="0" value="{{ old('berat') }}">
                                @error('berat')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="stock">Stock :</label>
                                <input type="number" name="stock"
                                    class="form-control @error('stock') is-invalid @enderror" id="stock"
                                    placeholder="Please Enter Stock" min="0" value="{{ old('stock') }}">
                                @error('stock')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="image">Image :</label>
                                <div class="custom-file">
                                    <input name="image" type="file" class="custom-file-input" id="image">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                </div>
                                <small class="form-text text-muted">* Max file 2MB jpg|png|jpeg</small>
                                @error('image')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="desc">Desc :</label>
                                <textarea name="desc" class="form-control @error('desc') is-invalid @enderror" id="desc" maxlength="150">{{ old('desc') }}</textarea>
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
@endsection

@push('jslib')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.js') }}"></script>
@endpush

@push('js')
    <script>
        bsCustomFileInput.init()

        if (jQuery().select2) {
            $(".select2").select2({
                allowClear: true
            });
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
