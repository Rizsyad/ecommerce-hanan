@extends('template.template_login')

@section('title', 'Register')

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
                                <h3>Register to <strong>Ecommerce</strong></h3>
                            </div>
                            <form action="{{ route('proses-register') }}" method="post">
                                @csrf
                                 <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="email@email.com"
                                        id="email">
                                    <small class="form-text text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="name">Username</label>
                                    <input type="text" class="form-control" name="name" placeholder="username"
                                        id="name" />
                                    <small class="form-text text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                               
                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Your Password"
                                        id="password" />
                                    <small class="form-text text-danger">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <button type="submit" class="btn btn-block btn-primary">Register</button>

                                <p class="text-center mt-3">Already have an account ? <a href="{{ route('login') }}">Sign In</a> </p>
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
