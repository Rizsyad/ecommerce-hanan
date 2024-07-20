@extends('template.template_dashboard')

@section('title', 'Lists Orders')

@section('head')

@endsection

@section('content-back')
    <div class="row">
        <div class="col-lg-12 mb-2">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Detail Orders</h4>
            </div>
        </div>

        <div class="col-lg-12 ">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Number Invoice:</th>
                                            <th>#{{$order->order_number}}</th>

                                        </tr>
                                        <tr>
                                            <th>User:</th>
                                            <th>{{$order->user->name}}</th>
                                        </tr>
                                        <tr>
                                            <th>Address:</th>
                                            <th>{{$order->address}}</th>
                                        </tr>
                                        <tr>
                                            <th>Status:</th>
                                            <th>
                                                @if($order->status == 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($order->status == 'processing')
                                                    <span class="badge bg-primary text-white">Processing</span>
                                                @elseif($order->status == 'completed')
                                                    <span class="badge bg-success text-white">Success</span>
                                                @elseif($order->status == 'cancelled')
                                                    <span class="badge bg-danger text-white">Cancel</span>
                                                @endif
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Total Amount:</th>
                                            <th>Rp. {{number_format($order->total_amount, 0, ',', '.')}}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('dashboard.orders.updateStatus', $order->order_number)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <h5>Confirmation</h5>
                                <h6 class="text-muted">Please confirm your order details</h6>
                                <select name="status" id="" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="pending" @if($order->status == 'pending') selected @endif>Pending</option>
                                    <option value="processing" @if($order->status == 'processing') selected @endif>Processing</option>
                                    <option value="completed" @if($order->status == 'completed') selected @endif>Completed</option>
                                    <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Cancelled</option>
                                </select>
    
                                @if ($order->status == 'pending' || $order->status == 'processing')
                                    <button type="submit" class="btn btn-primary w-100 mt-3">Proceed to Payment</button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($order->orderItems as $item)
                    <tr>
                        <td>
                            <span class="fw-medium">{{ $loop->iteration }}</span>
                        </td>
                        <td>
                            <span class="fw-medium">{{ $item->product->name_product }}</span>
                        </td>
                        <td>
                            <span class="fw-medium">Rp. {{ number_format($item->product->price, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <span class="fw-medium">{{$item->quantity}}</span>
                        </td>
                        <td>
                            <span class="fw-medium">Rp. {{ number_format($item->product->price * $item->quantity, 0, ',', '.')}}</span>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>Subtotal</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Rp. {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Payment</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Bank Transfer</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
