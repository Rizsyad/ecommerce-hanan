<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta content="ecommers" name="keywords" />
    <meta content="ecommers" name="description" />

    <title>@yield('title') | {{env('APP_NAME')}}</title>

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

    @yield('content')

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
     <script src="{{asset('assets/js/home.js')}}"></script>

    @yield('footer')
</body>

</html>
