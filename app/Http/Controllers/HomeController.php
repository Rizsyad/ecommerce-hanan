<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCart;
use App\Models\ProductReviews;
use Illuminate\Http\Request;

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

        $data = [
            'header' => $header,
        ];

        $search = $request->search;
        $sort = $request->sort;

        $data['products'] = Product::query();

        if ($search) {
            $data['products'] = $data['products']->where('name_product', 'like', '%' . $search . '%');
        }

        if ($sort) {
            if ($sort === 'asc') {
                $data['products'] = $data['products']->orderBy('price', 'asc');
            } elseif ($sort === 'desc') {
                $data['products'] = $data['products']->orderBy('price', 'desc');
            } elseif ($sort === 'rating') {
                $data['products'] = $data['products']->orderBy('rating', 'desc');
            } else {
                $data['products'] = $data['products']->latest();
            }
        }

        $data['products'] = $data['products']->paginate(12);

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
        $checkProduct = Product::find($id);

        if (!$checkProduct) {
            abort(404);
        }

        // Periksa apakah produk memiliki stok yang cukup
        if ($checkProduct->stock <= 0) {
            return back()->withErrors(['msg' => 'Product out of stock']);
        }
    
        $userId = auth()->user()->id;
        $checkInCart = ProductCart::where('product_id', $checkProduct->id)->where('user_id', $userId)->first();
    
        // jika sudah ada di cart maka update jumlahnya
        if ($checkInCart) {
            $checkInCart->quantity += 1;
            $checkInCart->save();
        } else {
            // jika belum ada di cart, tambahkan ke cart
            ProductCart::create([
                'user_id' => $userId,
                'product_id' => $checkProduct->id,
                'quantity' => 1
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
            'quantity' => 'required|integer|min:1'
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

        $cart = ProductCart::select('id', 'product_id', 'user_id', 'quantity')->with(
            [
                'product' => function ($query) {
                    $query->select('id', 'image', 'name_product', 'price'); 
                },
                'user' => function ($query) {
                    $query->select('id', 'name');
                },
            ]
            )->get();

        $data = [
            'header' => $header,
            'cart' => $cart
        ];

        return view('cart', compact('data'));
    }

    public function checkout()
    {
        $header = [
            'title' => 'checkout',
            'menu' => 'checkout',
        ];

        $cart = ProductCart::select('id', 'product_id', 'user_id', 'quantity')->with(
            [
                'product' => function ($query) {
                    $query->select('id', 'name_product', 'price');
                },
                'user' => function ($query) {
                    $query->select('id', 'name');
                },
            ]
            )->get();

        $data = [
            'header' => $header,
            'cart' => $cart
        ];

        return view('checkout', compact('data'));
    }
}
