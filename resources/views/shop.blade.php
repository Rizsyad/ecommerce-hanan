@extends('template.template_home')

@section('title', 'Shop')

@section('head')

@endsection

@section('content')
    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <!-- Price Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by price</h5>
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="price-all">
                            <label class="custom-control-label" for="price-all">All Price</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-1">
                            <label class="custom-control-label" for="price-1">$0 - $100</label>
                            <span class="badge border font-weight-normal">150</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-2">
                            <label class="custom-control-label" for="price-2">$100 - $200</label>
                            <span class="badge border font-weight-normal">295</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-3">
                            <label class="custom-control-label" for="price-3">$200 - $300</label>
                            <span class="badge border font-weight-normal">246</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-4">
                            <label class="custom-control-label" for="price-4">$300 - $400</label>
                            <span class="badge border font-weight-normal">145</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="price-5">
                            <label class="custom-control-label" for="price-5">$400 - $500</label>
                            <span class="badge border font-weight-normal">168</span>
                        </div>
                    </form>
                </div>
                <!-- Price End -->

            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-12">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <form action="">
                                <div class="input-group">
                                    <form action="{{ route('home.shop') }}" method="GET" id="sortForm">
                                        <input type="text" name="search" class="form-control" placeholder="Search by name product" value="{{ request('search') }}">
                                        <input type="hidden" name="sort" id="sort" value="{{ request('sort') }}">

                                        <button type="submit" class="input-group-text bg-transparent text-primary">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>
                                    
                                </div>
                            </form>
                            <div class="dropdown ml-4">
                                <button class="btn border dropdown-toggle" type="button" id="triggerId"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Sort by
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="setSortAndSubmit('asc')">Ascending</a>
                                    {{-- <a class="dropdown-item" href="javascript:void(0);" onclick="document.getElementById('sort').value='asc'; document.getElementById('sortForm').submit();">Ascending</a> --}}
                                    {{-- <a class="dropdown-item" href="javascript:void(0);" onclick="document.getElementById('sort').value='desc'; document.getElementById('sortForm').submit();">Latest</a> --}}
                                    {{-- <a class="dropdown-item" href="javascript:void(0);" onclick="setSortAndSubmit('asc')">Oldest</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="setSortAndSubmit('rating')">Rating</a> --}}
                                    {{-- <a class="dropdown-item" href="#" onclick="document.getElementById('sort').value='rating'; document.getElementById('sortForm').submit();">Best Rating</a> --}}
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @include('components.products', ['css_col' => 'col-lg-4'])

                    <div class="col-12 pb-1">
                        {{ $data['products']->links() }}
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection

<script>
   document.addEventListener('DOMContentLoaded', function () {
        window.setSortAndSubmit = function(sortValue) {
            console.log(sortValue);
            document.getElementById('sort').value = sortValue;
            document.getElementById('sortForm').submit();
        };
    });
</script>
