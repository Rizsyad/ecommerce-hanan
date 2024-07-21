@extends('template.template_home')

@section('title', 'Product')

@section('head')
@endsection

@section('content')
    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Product Start -->
            <div class="col-md-12">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <form action="{{ route('home.shop') }}" method="GET" id="sortForm">
                                <div class="input-group">
                                    <input type="text" name="search" id="search" class="form-control"
                                        placeholder="Search by name product" value="{{ request('search') }}" />
                                    <input type="hidden" name="sort" id="sort" value="{{ request('sort') }}" />
                                    <input type="hidden" name="category" value="{{ request('category') }}" />
                                    <input type="hidden" name="page" value="{{ request('page') }}" />

                                    <button type="submit" class="input-group-text bg-transparent text-primary">
                                        <i class="fa fa-search"></i>
                                    </button>

                                </div>
                            </form>
                            <div class="dropdown ml-4">
                                <button class="btn border dropdown-toggle" type="button" id="triggerId"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Sort by
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                    <a class="dropdown-item sorting" data-sort="asc">Ascending</a>
                                    <a class="dropdown-item sorting" data-sort="desc">Descending</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('components.products', ['css_col' => 'col-lg-3'])

                    <div class="col-12 pb-1">
                        {{ $data['products']->links('components.paginate') }}
                    </div>

                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $(".sorting").on('click', function() {
                var sortValue = $(this).data("sort")
                var sort = $("#sort").val(sortValue)
                $('#sortForm').submit();
            });
        })
    </script>
@endsection
