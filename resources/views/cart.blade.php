@extends('template.template_home')

@section('title', 'Cart')

@section('head')

@endsection

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        {{ \Session::get('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <b>Opps!</b> {{ $errors->first() }}
                    </div>
                @endif

                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($data['cart'] as $cart)
                            @php
                                $total += $cart->product->price * $cart->quantity;
                            @endphp

                            <tr>
                                <td class="align-middle">
                                    <img src="{{ asset('storage/' . $cart->product->image) }}"
                                        alt="img {{ $cart->product->name_product }}" style="width: 50px;" />
                                    {{ $cart->product->name_product }}
                                </td>
                                <td class="align-middle">
                                    Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                                </td>
                                <td class="align-middle">
                                    <form action="{{route('home.updateCart', $cart->product->id)}}" method="post">
                                        @csrf
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-sm btn-primary btn-minus">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" name="quantity" class="form-control form-control-sm bg-secondary text-center"
                                                value="{{ $cart->quantity }}">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-sm btn-primary btn-plus">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td class="align-middle">
                                    Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('home.removeFromCart', $cart->product->id) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">Rp {{ number_format($total, 0, ',', '.') }}</h6>
                        </div>
                        {{-- <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$10</h6>
                        </div> --}}
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                        </div>
                        <a href="{{route('home.checkout')}}" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('footer')

@endsection
