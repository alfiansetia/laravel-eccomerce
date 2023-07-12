@extends('layouts.template')

@push('csslib')
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@push('css')
    <style>
        .bloc_left_price {
            color: #c01508;
            text-align: center;
            font-weight: bold;
            font-size: 150%;
        }

        .category_block li:hover {
            background-color: #007bff;
        }

        .category_block li:hover a {
            color: #ffffff;
        }

        .category_block li a {
            color: #343a40;
        }

        .add_to_cart_block .price {
            color: #c01508;
            text-align: center;
            font-weight: bold;
            font-size: 200%;
            margin-bottom: 0;
        }

        .add_to_cart_block .price_discounted {
            color: #343a40;
            text-align: center;
            text-decoration: line-through;
            font-size: 140%;
        }

        .product_rassurance {
            padding: 10px;
            margin-top: 15px;
            background: #ffffff;
            border: 1px solid #6c757d;
            color: #6c757d;
        }

        .product_rassurance .list-inline {
            margin-bottom: 0;
            text-transform: uppercase;
            text-align: center;
        }

        .product_rassurance .list-inline li:hover {
            color: #343a40;
        }

        .reviews_product .fa-star {
            color: gold;
        }

        .pagination {
            margin-top: 20px;
        }

        footer {
            background: #343a40;
            padding: 40px;
        }

        footer a {
            color: #f8f9fa !important
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-3">
                <div class="card bg-light mb-3">
                    <div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-list"></i> Categories
                    </div>
                    <ul class="list-group category_block">
                        @foreach ($kategori as $item)
                            <li class="list-group-item"><a
                                    href="{{ route('home') }}?kategory={{ $item->name }}">{{ $item->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="card bg-light mb-3">
                    <div class="card-header bg-success text-white text-uppercase">Last product</div>
                    @if ($last)
                        <div class="card-body">
                            <img class="img-fluid" src="{{ $last->image }}" />
                            <h5 class="card-title">{{ $last->name }}</h5>
                            <p class="card-text">{{ $last->desc }}</p>
                            <p class="bloc_left_price">{{ $last->harga_jual }}</p>
                        </div>
                    @else
                        <div class="alert alert-danger">No Data </div>
                    @endif
                </div>
            </div>
            <div class="col">
                <div class="row">
                    @foreach ($product as $item)
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <article class="article">
                                <div class="article-header">
                                    <div class="article-image" data-background="{{ $item->image }}">
                                    </div>
                                    <div class="article-title">
                                        <h2><a href="{{ route('product.show', $item->id) }}">{{ $item->name }}</a></h2>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <p>{{ $item->desc }}</p>
                                    <div class="article-cta">
                                        <button type="button" class="btn btn-danger">{{ $item->harga_jual }}</button>
                                        <button type="button" class="btn btn-primary"
                                            onclick="addData('{{ $item->id }}')">Add to cart</button>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                    <div class="col-12 text-center">
                        {{ $product->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="add" action="{{ route('cart.store') }}" method="POST">
        <input type="hidden" name="product" id="product">
        @csrf
    </form>

    <!-- Footer -->
    {{-- <footer class="text-light">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-lg-4 col-xl-3">
                    <h5>About</h5>
                    <hr class="bg-white mb-2 mt-0 d-inline-block mx-auto w-25">
                    <p class="mb-0">
                        Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant
                        impression.
                    </p>
                </div>

                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto">
                    <h5>Informations</h5>
                    <hr class="bg-white mb-2 mt-0 d-inline-block mx-auto w-25">
                    <ul class="list-unstyled">
                        <li><a href="">Link 1</a></li>
                        <li><a href="">Link 2</a></li>
                        <li><a href="">Link 3</a></li>
                        <li><a href="">Link 4</a></li>
                    </ul>
                </div>

                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto">
                    <h5>Others links</h5>
                    <hr class="bg-white mb-2 mt-0 d-inline-block mx-auto w-25">
                    <ul class="list-unstyled">
                        <li><a href="">Link 1</a></li>
                        <li><a href="">Link 2</a></li>
                        <li><a href="">Link 3</a></li>
                        <li><a href="">Link 4</a></li>
                    </ul>
                </div>

                <div class="col-md-4 col-lg-3 col-xl-3">
                    <h5>Contact</h5>
                    <hr class="bg-white mb-2 mt-0 d-inline-block mx-auto w-25">
                    <ul class="list-unstyled">
                        <li><i class="fa fa-home mr-2"></i> My company</li>
                        <li><i class="fa fa-envelope mr-2"></i> email@example.com</li>
                        <li><i class="fa fa-phone mr-2"></i> + 33 12 14 15 16</li>
                        <li><i class="fa fa-print mr-2"></i> + 33 12 14 15 16</li>
                    </ul>
                </div>
                <div class="col-12 copyright mt-3">
                    <p class="float-left">
                        <a href="#">Back to top</a>
                    </p>
                    <p class="text-right text-muted">created with <i class="fa fa-heart"></i> by <a
                            href="https://t-php.fr/43-theme-ecommerce-bootstrap-4.html"><i>t-php</i></a> | <span>v.
                            1.0</span></p>
                </div>
            </div>
        </div>
    </footer> --}}
@endsection


@push('jslib')
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('js')
    @error('product')
        <script>
            swal("Error", "{{ $message }}", 'error');
        </script>
    @enderror
    <script>
        function addData(id) {
            swal({
                title: 'Add to Cart?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then(function(result) {
                if (result) {
                    var addForm = $('#add');
                    $('#product').val(id)
                    addForm.submit();
                    block();
                }
            })

        }
    </script>
@endpush
