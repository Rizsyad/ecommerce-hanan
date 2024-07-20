<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\ProductCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function __construct()
    {
        // panggil categories secara global
        $this->shareCategories();
    }

    // buat function untuk memanggil secara global
    private function shareCategories()
    {
        $categories = Category::select('id', 'name_category')->latest()->get();
        view()->share('categories', $categories);
    }

    public function index()
    {
        $data['products'] = Product::latest()->limit(8)->get();
        $data['homeCategories'] = Category::withCount('products')->latest()->limit(4)->get();
        return view('index', compact('data'));
    }

    public function shop(Request $request)
    {
        $header = [
            'title' => 'Our Shop',
            'menu' => 'Shop',
        ];

        $search = $request->search;
        $sort = $request->sort;

        $products = Product::query();

        if ($search) {
            $products = $products->where('name_product', 'like', '%' . $search . '%');
        }

        if ($sort) {
            if ($sort === 'asc') {
                $products = $products->orderBy('price', 'asc');
            } elseif ($sort === 'desc') {
                $products = $products->orderBy('price', 'desc');
            } else {
                $products = $products->latest();
            }
        }

        $data = [
            'header' => $header,
            'products' => $products->paginate(),
        ];

        return view('shop', compact('data'));
    }

    public function shopDetail(Request $request)
    {
        // jika tidak mempunyai session, redirect ke login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $header = [
            'title' => 'SHOP DETAIL',
            'menu' => 'Shop Detail',
        ];

        $product = Product::with([
            'images' => function ($query) {
                $query->select('product_id', 'image');
            },
            'reviews' => function ($query) {
                $query->select('id', 'product_id', 'rating', 'review', 'user_id');
            },
            'reviews.user' => function ($query) {
                $query->select('id', 'name');
            },
        ])
            ->withCount('reviews')
            ->where('slug', $request->slug)
            ->first();

        // cek jika tidak ada proudct maka error page 404
        if (!$product) {
            abort(404);
        }

        $randomProduct = Product::where('slug', '!=', $request->slug)
            ->inRandomOrder()
            ->limit(8)
            ->get();
        $avgRating = round($product->reviews->avg('rating'));
        $userReviewed = $product
            ->reviews()
            ->where([
                'user_id' => auth()->user()->id,
                'product_id' => $product->id,
            ])
            ->exists();

        $data = [
            'header' => $header,
            'product' => $product,
            'avgRating' => $avgRating,
            'randomProduct' => $randomProduct,
            'isUserReviewed' => $userReviewed,
        ];

        return view('shop-details', compact('data'));
    }

    public function productReview(string $id, Request $request)
    {
        $request->validate([
            'rating' => 'required|digits_between:1,5',
            'review' => 'required',
        ]);

        $product = Product::find($id);

        $checkIsReviewed = $product
            ->reviews()
            ->where([
                'user_id' => auth()->user()->id,
                'product_id' => $id,
            ])
            ->exists();

        if ($checkIsReviewed) {
            return back()->withErrors(['msg' => 'You have already reviewed this product']);
        }

        $product->reviews()->create([
            'user_id' => auth()->user()->id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Successfully reviewed this product');
    }

    public function addToCart(string $id)
    {
        // jika tidak mempunyai session, redirect ke login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $checkProduct = Product::find($id);

        if (!$checkProduct) {
            abort(404);
        }

        // Periksa apakah produk memiliki stok yang cukup
        if ($checkProduct->stock <= 0) {
            return back()->withErrors(['msg' => 'Product out of stock']);
        }

        $userId = auth()->user()->id;
        $checkInCart = ProductCart::where('product_id', $checkProduct->id)
            ->where('user_id', $userId)
            ->first();

        // jika sudah ada di cart maka update jumlahnya
        if ($checkInCart) {
            $checkInCart->quantity += 1;
            $checkInCart->save();
        } else {
            // jika belum ada di cart, tambahkan ke cart
            ProductCart::create([
                'user_id' => $userId,
                'product_id' => $checkProduct->id,
                'quantity' => 1,
            ]);
        }

        // Kurangi stok produk
        $checkProduct->stock -= 1;
        $checkProduct->save();

        return redirect(route('home.cart'))->with('success', 'Successfully add to cart');
    }

    public function removeFromCart(string $id)
    {
        $userId = auth()->user()->id;
        $checkInCart = ProductCart::where('product_id', $id)->where('user_id', $userId)->first();

        if (!$checkInCart) {
            return back()->withErrors(['msg' => 'Product not found in cart']);
        }

        $product = Product::find($id);

        // Kembalikan stok produk
        $product->stock += $checkInCart->quantity;
        $product->save();

        // Hapus produk dari keranjang
        $checkInCart->delete();

        return back()->with('success', 'Product removed from cart successfully');
    }

    public function updateCart(Request $request, string $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = auth()->user()->id;
        $checkInCart = ProductCart::where('product_id', $id)->where('user_id', $userId)->first();

        if (!$checkInCart) {
            return back()->withErrors(['msg' => 'Product not found in cart']);
        }

        $product = Product::find($id);

        $newQuantity = $request->input('quantity');
        $currentQuantity = $checkInCart->quantity;

        if ($newQuantity > $currentQuantity) {
            $difference = $newQuantity - $currentQuantity;

            // Periksa apakah ada stok yang cukup
            if ($product->stock < $difference) {
                return back()->withErrors(['msg' => 'Not enough stock available']);
            }

            // Kurangi stok produk
            $product->stock -= $difference;
        } else {
            $difference = $currentQuantity - $newQuantity;

            // Kembalikan stok produk
            $product->stock += $difference;
        }

        $product->save();

        // Update jumlah di keranjang
        $checkInCart->quantity = $newQuantity;
        $checkInCart->save();

        return back()->with('success', 'Cart updated successfully');
    }

    public function cart()
    {
        $header = [
            'title' => 'Cart',
            'menu' => 'Cart',
        ];

        $cart = ProductCart::select('id', 'product_id', 'user_id', 'quantity')
            ->with([
                'product' => function ($query) {
                    $query->select('id', 'image', 'name_product', 'price');
                },
                'user' => function ($query) {
                    $query->select('id', 'name');
                },
            ])
            ->get();

        $data = [
            'header' => $header,
            'cart' => $cart,
        ];

        return view('cart', compact('data'));
    }

    public function checkout()
    {
        $header = [
            'title' => 'checkout',
            'menu' => 'checkout',
        ];

        $cart = ProductCart::select('id', 'product_id', 'user_id', 'quantity')
            ->with([
                'product' => function ($query) {
                    $query->select('id', 'name_product', 'price');
                },
                'user' => function ($query) {
                    $query->select('id', 'name');
                },
            ])
            ->get();

        $data = [
            'header' => $header,
            'cart' => $cart,
        ];

        return view('checkout', compact('data'));
    }

    public function checkoutprocess(Request $request)
    {
        // Validasi input
        $request->validate([
            'address' => 'required',
        ]);

        $address = $request->address;
        $userId = auth()->user()->id;

        // Ambil produk di keranjang belanja
        $cartItems = ProductCart::with('product')->where('user_id', $userId)->get();

        // Cek jika keranjang belanja kosong
        if ($cartItems->isEmpty()) {
            return back()->withErrors(['msg' => 'Sorry your cart is empty']);
        }

        // Hitung total jumlah
        $totalAmount = $cartItems->sum(function ($cart) {
            return $cart->quantity * $cart->product->price;
        });

        // Buat pesanan baru
        $order = Order::create([
            'user_id' => $userId,
            'order_number' => rand(0, 200),
            'total_amount' => $totalAmount,
            'address' => $address,
        ]);

        // Cek jika pesanan gagal dibuat
        if (!$order) {
            return back()->withErrors(['msg' => 'Order cannot be processed']);
        }

        // Siapkan data item pesanan
        $orderItemsData = $cartItems
            ->map(function ($cart) use ($order) {
                return [
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'amount' => $cart->quantity * $cart->product->price,
                ];
            })
            ->toArray();

        // Insert item pesanan
        $orderItemsInserted = OrderItems::insert($orderItemsData);

        // Cek jika insert item pesanan gagal
        if (!$orderItemsInserted) {
            $order->delete();
            return back()->withErrors(['msg' => 'Order cannot be processed']);
        }

        // Hapus semua item di keranjang belanja
        ProductCart::where('user_id', $userId)->delete();

        // Ambil detail pesanan untuk email
        $orderItems = OrderItems::with(['order', 'product'])
            ->where('order_id', $order->id)
            ->get();
        $orderDetails = Order::with('user')
            ->where('id', $order->id)
            ->first();

        // Kirim email invoice
        Mail::to(auth()->user())->send(new InvoiceMail($orderItems, $orderDetails));

        // Redirect ke halaman terima kasih
        return redirect(route('home.thankyou'));
    }

    // public function checkoutprocess(Request $request)
    // {
    //     $request->validate([
    //         // 'payment' => 'required',
    //         'address' => 'required'
    //     ]);

    //     // $payment = $request->payment;
    //     $address = $request->address;

    //     $getCart = ProductCart::with('product')->where('user_id', auth()->user()->id)->get();

    //     // Cek jika keranjang belanja kosong
    //     if ($getCart->isEmpty()) {
    //         return back()->withErrors(['msg' => 'Sorry your cart is empty']);
    //     }

    //     $orders = Order::create([
    //         'user_id' => auth()->user()->id,
    //         'order_number' => rand(0, 200),
    //         'total_amount' => $getCart->sum(function ($cart) {
    //             return $cart->quantity * $cart->product->price;
    //         }),
    //         'address' => $address
    //     ]);

    //     if(!$orders) {
    //         return back()->withErrors(['msg' => "Order cannot be processed"]);
    //     }

    //     $data = [];
    //     foreach ($getCart as $cart) {
    //         array_push($data, [
    //             "order_id" => $orders->id,
    //             "product_id" => $cart->product_id,
    //             'quantity' => $cart->quantity,
    //             "amount" => $cart->quantity * $cart->product->price
    //         ]);
    //     }

    //     $orderItem = OrderItems::insert($data);

    //     if(!$orderItem) {
    //         Order::find($orders->id)->delete();
    //         return back()->withErrors(['msg' => "Order cannot be processed"]);
    //     }

    //     ProductCart::with('product')->where('user_id', auth()->user()->id)->delete();

    //     $orderItems = OrderItems::with(['order', 'product'])->where('order_id', $orders->id)->get();
    //     $detailInfo = Order::with('user')->where('id', $orders->id)->first();

    //     Mail::to('riz@gmail.com')->send(new InvoiceMail($orderItems, $detailInfo));

    //     return redirect(route('home.thankyou'));
    // }
}
