    <!-- Navbar Start -->
    <div class="container-fluid {{ request()->is('/') ? 'mb-5' : '' }}">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                    data-toggle="collapse" href="#navbar-vertical"
                    style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>

                @if (request()->is('page/'))
                    @include('components.header')
                @endif

                @if (request()->is('/'))
                    <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0"
                        id="navbar-vertical">
                    @else
                        <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light"
                            id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                @endif

                <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                    @foreach ($categories as $item)
                        <a href="{{route('home.shop')}}?category={{$item->id}}" class="nav-item nav-link">{{ $item->name_category }}</a>
                    @endforeach
                </div>

                </nav>

            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold">
                            <span class="text-primary font-weight-bold border px-3 mr-1">Hanan</span>
                            Store
                        </h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{ route('home.index') }}"
                                class="nav-item nav-link {{ request()->routeIs('home.index') ? 'active' : '' }}">Home</a>
                            <a href="{{ route('home.shop') }}"
                                class="nav-item nav-link {{ request()->routeIs('home.shop') ? 'active' : '' }}">Shop</a>
                        </div>

                        @guest
                            <div class="navbar-nav ml-auto py-0">
                                <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                                <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
                            </div>
                        @endguest

                        @auth
                            <div class="navbar-nav ml-auto py-0">
                                <p class="nav-item nav-link">Welcome Back, <b>{{ auth()->user()->name }}</b></p>


                                <a href="{{ route('logout') }}" class="nav-item nav-link">Logout</a>
                            </div>
                        @endauth

                    </div>
                </nav>

                @if (request()->routeIs('home.index'))
                    @include('components.carousel')
                @endif
            </div>
        </div>
    </div>
    <!-- Navbar End -->

    {{-- cek jika page adalah bukan index --}}
    @if (!request()->routeIs('home.index'))
        @include('components.header')
    @endif
