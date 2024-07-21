    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">

            @foreach ($data['homeCategories'] as $item)
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                    <p class="text-right">{{ $item->products_count }} Products</p>
                    <a href="{{route('home.shop')}}?category={{$item->id}}" class="cat-img position-relative overflow-hidden mb-3">
                        @if (!$item->image)
                            <img src="{{asset('noimage.jpg')}}"  class="img-fluid" style="height: 250px; width: 100%" alt="">
                        @else
                            <img src="{{asset('storage/'.$item->image)}}" class="img-fluid" style="height: 250px; width: 100%" alt="">
                        @endif
                    </a>
                    <h5 class="font-weight-semi-bold m-0">{{ $item->name_category }}</h5>
                </div>
            </div>
                
            @endforeach
            
        </div>
    </div>
    <!-- Categories End -->