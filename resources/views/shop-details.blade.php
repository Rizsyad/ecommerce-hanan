@extends('template.template_home')

@section('title', 'Product Detail')

@section('head')
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/css/star-rating.min.css" media="all"
        rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/themes/krajee-svg/theme.css" media="all"
        rel="stylesheet" type="text/css" />
@endsection

@section('footer')
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/js/star-rating.min.js"
        type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('#rating').rating();
        });
    </script>
@endsection

@section('content')
    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{ asset('storage/' . $data['product']['image']) }}"
                                alt="Image {{ $data['product']['name_product'] }}" />
                        </div>
                        @foreach ($data['product']['images'] as $image)
                            <div class="carousel-item">
                                <img class="w-100 h-100" src="{{ asset('storage/' . $image->image) }}" alt="Image" />
                            </div>
                        @endforeach

                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold">{{ $data['product']['name_product'] }}</h3>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $data['avgRating'])
                                <small class="fas fa-star"></small>
                            @else
                                <small class="fas fa-star text-muted"></small>
                            @endif
                        @endfor
                    </div>
                    <small class="pt-1">({{ $data['product']['reviews_count'] }} Reviews)</small>
                </div>

                <h3 class="font-weight-semi-bold mb-4">Rp. {{ number_format($data['product']['price'], 0, ',', '.') }}</h3>
                <p class="mb-4"> {{ $data['product']['description'] }}
                </p>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <b>Opps!</b> {{ $errors->first() }}
                    </div>
                @endif


                <div class="d-flex align-items-center mb-4 pt-2">
                    <a href="{{ route('home.addToCart', $data['product']['id']) }}" class="btn btn-primary px-3"><i
                            class="fa fa-shopping-cart mr-1"></i> Add To
                        Cart</a>
                </div>
            </div>

        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews
                        ({{ $data['product']['reviews_count'] }})</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>
                        <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt
                            duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur
                            invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet
                            rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam
                            consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam,
                            ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr
                            sanctus eirmod takimata dolor ea invidunt.</p>
                        <p>Dolore magna est eirmod sanctus dolor, amet diam et eirmod et ipsum. Amet dolore tempor
                            consetetur sed lorem dolor sit lorem tempor. Gubergren amet amet labore sadipscing clita clita
                            diam clita. Sea amet et sed ipsum lorem elitr et, amet et labore voluptua sit rebum. Ea erat sed
                            et diam takimata sed justo. Magna takimata justo et amet magna et.</p>
                    </div>
                    
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">{{ $data['product']['reviews_count'] }} review for
                                    "{{ $data['product']['name_product'] }}"</h4>
                                @foreach ($data['product']['reviews'] as $review)
                                    <div class="media mb-4">
                                        <img src="https://ui-avatars.com/api/?background=random&rounded=true&name={{ $review->user->name }}"
                                            alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                        <div class="media-body">
                                            <h6>{{ $review->user->name }}<small> -
                                                    <i>{{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}</i></small>
                                            </h6>
                                            <div class="text-primary mb-2">
                                                @for ($i = 0; $i < $review->rating; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                            </div>
                                            <p>{{ $review->review }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                @guest
                                    <h4 class="mb-4">You must <a href="{{ route('login') }}">Login</a> for leave a review.
                                    </h4>
                                @endguest
                                @auth
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <b>Opps!</b> {{ $errors->first() }}
                                        </div>
                                    @endif

                                    @if (\Session::has('success'))
                                        <div class="alert alert-success">
                                            {{ \Session::get('success') }}
                                        </div>
                                    @endif

                                    @if ($data['isUserReviewed'])
                                        <h4 class="mb-4">You have reviewed this product</h4>
                                    @else
                                        <h4 class="mb-4">Leave a review</h4>
                                        <small>Your email address will not be published. Required fields are marked *</small>

                                        <form action="{{ route('home.storeReview', $data['product']['id']) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <div class="d-flex my-3">
                                                    <p class="mb-0 mr-2">Your Rating * :</p>
                                                    <div class="text-primary">
                                                        <input id="rating" name="rating" class="rating rating-loading"
                                                            data-show-clear="false" data-show-caption="false" data-step="1"
                                                            data-size="xs" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="review">Your Review *</label>
                                                <textarea id="review" cols="30" rows="5" name="review" class="form-control"></textarea>
                                                <small class="form-text text-muted">Review Max 255 words</small></small>
                                            </div>

                                            <div class="form-group mb-0">
                                                <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                            </div>
                                        </form>
                                    @endif


                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->

    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
        </div>
        <div class="row px-xl-5">
            @foreach ($data['randomProduct'] as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="card product-item border-0">
                    <div
                        class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="{{ asset('storage/' . $product->image) }}"
                            alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{ $product->name_product }}</h6>
                        <div class="d-flex justify-content-center">
                            <h6>Rp. {{ number_format($product->price, 0, ',', '.') }}</h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{ route('home.shopDetail', $product->slug) }}"
                            class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View
                            Detail</a>
                        <a href="{{ route('home.addToCart', $product->id) }}" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i>
                            Add To Cart
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>
    <!-- Products End -->
@endsection

