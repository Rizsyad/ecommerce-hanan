@extends('template.template_dashboard')

@section('title', 'Lists Orders')

@section('head')

@endsection

@section('content-back')
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
                                <span class="fw-medium">Rp. {{ number_format($order->total_amount, 0, ',', '.') }}</span>
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
                                <a href="{{route('dashboard.orders.detail', $order->order_number)}}" class="btn btn-primary">Detail</a>
                            </td>

                            
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
