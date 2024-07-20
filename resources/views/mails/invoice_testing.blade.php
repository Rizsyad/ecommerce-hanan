@foreach ($orderItems as $item)
    {{-- {{$item}} --}}
        <li>{{ $item->order_id }} - {{ $item->product_id }} - {{ $item->quantity }}</li>
@endforeach