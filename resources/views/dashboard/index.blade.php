@extends('template.template_dashboard')

@section('title', 'Dashboard')

@section('head')

@endsection

@section('content-back')
    <div class="row">

        <div class="col-lg-12 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">

                            <span class="fw-medium d-block mb-1">Total Sales (Monthly)</span>
                            <h3 class="card-title mb-2">Rp. {{ number_format($data['totalAmountMonthly'], 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">

                            <span>Total Orders (Monthly)</span>
                            <h3 class="card-title mb-2">{{ $data['totalOrderMonthly'] }} </h3>

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">

                            <span>Product Sold (Monthly)</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $data['productSold'] }}</h3>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="col-lg-12 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-medium d-block mb-1">Status Order (Pending)</span>
                            <h3 class="card-title mb-2">{{ $data['orderTrackingStatus']['pending'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-medium d-block mb-1">Status Order (Processing)</span>
                            <h3 class="card-title mb-2">{{ $data['orderTrackingStatus']['processing'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-medium d-block mb-1">Status Order (Completed)</span>
                            <h3 class="card-title mb-2">{{ $data['orderTrackingStatus']['completed'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-medium d-block mb-1">Status Order (Cancelled)</span>
                            <h3 class="card-title mb-2">{{ $data['orderTrackingStatus']['cancelled'] }}</h3>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="col-lg-12 col-md-4 order-1">
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No Invoice</th>
                                <th>User</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <span class="fw-medium">{{ $loop->iteration }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $order->order_number }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $order->user->name }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-medium">Rp.
                                            {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                    </td>

                                    <td>
                                        @if ($order->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge bg-primary text-white">Processing</span>
                                        @elseif($order->status == 'completed')
                                            <span class="badge bg-success text-white">Success</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-danger text-white">Cancel</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('dashboard.orders.detail', $order->order_number) }}"
                                            class="btn btn-primary">Detail</a>
                                    </td>


                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
