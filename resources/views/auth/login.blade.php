@extends('components.template_login')

@section('title', 'Login')

@section('head')
@endsection

@section('content')
    <div class="half">
        <div class="bg order-1 order-md-2" style="background-image: url('/assets/img/banner.jpg');"></div>
        <div class="contents order-2 order-md-1">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-6">
                        <div class="form-block">
                            <div class="text-center mb-5">
                                <h3>Login to <strong>Ecommerce</strong></h3>
                            </div>
                            <form action="{{ route('loginProcess') }}" method="post">
                                @csrf
                                <div class="form-group first">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email"
                                        placeholder="your-email@gmail.com" id="email">
                                    <small class="form-text text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </small>

                                </div>
                                <div class="form-group last mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" placeholder="Your Password"
                                        id="password" />
                                    <small class="form-text text-danger">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <button type="submit" class="btn btn-block btn-primary">Log In</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

@endsection
