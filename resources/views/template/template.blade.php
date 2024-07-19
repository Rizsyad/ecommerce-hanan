<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta content="ecommers" name="keywords" />
    <meta content="ecommers" name="description" />

    <title>@yield('title')</title>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">


    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />

    @yield('head')
</head>

<body>
    @include('components.topbar')

    @include('components.navbar')


        {{-- <!-- Page Header Start -->
        <div class="container-fluid bg-secondary mb-5">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
                <h1 class="font-weight-semi-bold text-uppercase mb-3">Our Shop</h1>
                <div class="d-inline-flex">
                    <p class="m-0"><a href="">Home</a></p>
                    <p class="m-0 px-2">-</p>
                    <p class="m-0">Shop</p>
                </div>
            </div>
        </div>
        <!-- Page Header End --> --}}

    @include('components.featured')

    @include('components.categories')

    {{-- nyalakan jika perlu --}}
    {{-- @include('components.offer')  --}} 

    @include('components.products')

    @include('components.subscribe')

    @include('components.products')

    
{{-- @yield('content') --}}

    {{-- @include('components.vendor') --}}

    @include('components.footer')

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

     <!-- JavaScript Libraries -->
     <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
     <script src="{{asset('assets/lib/easing/easing.min.js')}}"></script>
     <script src="{{asset('assets/lib/owlcarousel/owl.carousel.min.js')}}"></script>
 
     {{-- <!-- Contact Javascript File --> --}}
     {{-- <script src="mail/jqBootstrapValidation.min.js"></script>
     <script src="mail/contact.js"></script> --}}
 
     <!-- Template Javascript -->
     <script src="{{asset('assets/js/main.js')}}"></script>

    @yield('footer')
</body>

</html>
