    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">{{$title}}</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @include('components.products', ['css_col' => 'col-lg-3'])
        </div>
    </div>
    <!-- Products End -->