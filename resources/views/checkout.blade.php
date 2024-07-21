@extends('template.template_home')

@section('title', 'Checkout')

@section('head')

@endsection

@section('content')
    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        @guest
            <h4 class="mb-4">You must <a href="{{ route('login') }}">Login</a> for continue checkout.</h4>
        @endguest
        @auth
            <form action="{{ route('home.checkoutprocess') }}" method="POST">
                @csrf
                <div class="row px-xl-5">
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label label="address">Address</label>
                                    <textarea name="address" id="" cols="10" rows="10" class="form-control">{{old('address')}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <b>Opps!</b> {{ $errors->first() }}
                            </div>
                        @endif
                        <div class="card border-secondary mb-5">
                            <div class="card-header bg-secondary border-0">
                                <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                            </div>
                            <div class="card-body">
                                <h5 class="font-weight-medium mb-3">Products</h5>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($data['cart'] as $cart)
                                    @php
                                        $total += $cart->product->price * $cart->quantity;
                                    @endphp
                                    <div class="d-flex justify-content-between">
                                        <p>{{ $cart->product->name_product }} x {{ $cart->quantity }}</p>
                                        <p>Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}</p>
                                    </div>
                                @endforeach
                                <hr class="mt-0">
                                <div class="d-flex justify-content-between mb-3 pt-1">
                                    <h6 class="font-weight-medium">Subtotal</h6>
                                    <h6 class="font-weight-medium">Rp {{ number_format($total, 0, ',', '.') }}</h6>
                                </div>
                            </div>
                            <div class="card-footer border-secondary bg-transparent">
                                <div class="d-flex justify-content-between mt-2">
                                    <h5 class="font-weight-bold">Total</h5>
                                    <h5 class="font-weight-bold">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card border-secondary mb-5">
                            <div class="card-header bg-secondary border-0">
                                <h4 class="font-weight-semi-bold m-0">Payment</h4>
                            </div>
                            <div class="card-body">
                                <p>
                                    Please transfer to BCA account: <br/>
                                    <b>A.N Jono Mahendra</b>  <br/>
                                    Bank No: <b>123456789</b> <br/>
                                    <br/>
                                    If you have transferred, please confirm via whatsapp below: 
                                    <b>08123456789</b>
                                </p>
                                {{-- <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="payment" id="banktransfer"
                                            value="banktransfer" />
                                        <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="card-footer border-secondary bg-transparent">
                                <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place
                                    Order</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        @endauth
    </div>

    <!-- Checkout End -->
@endsection

@section('footer')

@endsection
