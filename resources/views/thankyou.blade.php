<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Purchase</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="card p-4 w-100" style="max-width: 500px;">
                <div class="text-center mb-4">
                    <h1>E-Hannan</h1>
                </div>
                <div class="text-center mb-3">
                    <p>Thank you for your purchase! Below are the details of your order.</p>
                </div>
                <div class="mb-3">
                    <strong>Order by:</strong> {{$data['dataPurchase']['user']['name']}}
                </div>
                <div class="mb-3">
                    <strong>Invoice Number:</strong> #{{$data['dataPurchase']['order_number']}}
                </div>
                <div class="mb-3">
                    <strong>Shipping Address:</strong> <br>
                    {{$data['dataPurchase']['address']}}
                </div>
                <div class="product-list mb-3">
                @foreach ($data['dataPurchase']['orderItems'] as $item)
                        <div class="product d-flex align-items-center mb-2">
                            <img src="{{asset('storage/'.$item->product->image)}}" alt="Product 1" class="img-fluid mr-2" style="width: 50px;">
                            <span>{{$item->product->name_product}}</span>
                            <span class="ml-auto">Rp. {{number_format($item->product->price, 0, ',', '.')}}</span>
                        </div>
                    @endforeach
                </div>
                <div class="total text-right font-weight-bold">
                    Total: Rp. {{number_format($data['dataPurchase']['total_amount'], 0, ',', '.')}}
                </div>
                <div class="text-center mt-4">
                    @php
                        $message = urlencode(
                            "Halo admin, \n\n Saya telah membeli produk di E-Hannan. \n\n Invoice: #".$data['dataPurchase']['order_number']. "\n\n Total: Rp. ". number_format($data['dataPurchase']['total_amount'], 0, ',', '.')."\n\n Mohon untuk diperiksa dan berikut lampiran pembayaran saya. \n\n"
                        );
                    @endphp
                    <a href="https://wa.me/+6282122210770?text={{ $message }}" class="btn btn-success" target="_blank">Confirmation WhatsApp</a>
                </div>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
