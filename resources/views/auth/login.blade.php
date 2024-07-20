@extends('template.template_login')

@section('title', 'Login')

@section('head')
@endsection

@section('content')
    <div class="half">
        <div class="bg order-1 order-md-2" style="background-image: url('/assets/img/banner-1.jpeg');"></div>
        <div class="contents order-2 order-md-1">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-6">
                        <div class="form-block">
                            <div class="text-center mb-5">
                                <h3>Login to <strong>Ecommerce</strong></h3>
                                @if($errors->any())
                                <div class="alert alert-danger">
                                    <b>Opps!</b> {{$errors->first()}}
                                </div>
                                @endif
                            </div>
                            <form action="{{ route('proses-login') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email"
                                        placeholder="your-email@gmail.com" id="email">
                                    <small class="form-text text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Your Password"
                                        id="password" />
                                    <small class="form-text text-danger">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>

                                <button type="submit" class="btn btn-block btn-primary">Log In</button>

                                <p class="text-center mt-3">Don't have an account ? <a href="{{ route('register') }}">Sign Up</a> </p>
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
