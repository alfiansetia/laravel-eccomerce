<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Company;
use App\Models\Kota;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    private $title = 'Cart';
    private $company;

    public function __construct()
    {
        $this->company = Company::first();
    }

    public function index()
    {
        $data = Cart::where('user_id', auth()->id())->get();
        $kota = Kota::with('province')->get();
        return view('cart.data', compact(['data', 'kota']))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            // 'product' => 'required|integer|exists:products,id|unique:carts,product_id,' . $request->product . ',id,user_id,' . auth()->id(),
            'product' => [
                'required',
                'integer',
                'exists:products,id',
                'unique:carts,product_id,user_id',
                function ($attribute, $value, $fail) {
                    $product = Product::find($value);
                    if ($product && $product->stock < 1) {
                        $fail('Out of Stock');
                    }
                },
            ]
        ], [
            'product.exists' => 'Out Of Stock'
        ]);

        $cart = Cart::create([
            'user_id'    => auth()->id(),
            'product_id' => $request->product,
            'total'      => 1,
        ]);
        if ($cart) {
            return redirect()->back()->with(['success' => 'Success Insert to Cart']);
        } else {
            return redirect()->back()->with(['error' => 'Failed Insert to Cart']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        if (!$cart) {
            abort(404);
        }
        $this->validate($request, [
            'total' => 'required|integer|min:1|lte:' . $cart->product->stock,
        ], [
            'total.lte' => 'Out Of Stock',
            'total.min' => 'Min 1',
        ]);
        $cart = $cart->update([
            'total' => $request->total,
        ]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        if (!$cart) {
            abort(404);
        }
        $cart = $cart->delete();
        if ($cart) {
            return redirect()->back()->with(['success' => 'Success Delete from Cart']);
        } else {
            return redirect()->back()->with(['error' => 'Failed Delete from Cart']);
        }
    }


    public function checkout(Request $request)
    {
        $this->validate($request, [
            'courier' => 'required|in:pos,jne,tiki'
        ]);

        $key = env('RAJAONGKIR_KEY');
        $url = env('RAJAONGKIR_URL');
        if (empty($key) || empty($url)) {
            return redirect()->route('cart.index')->with(['error' => 'Error System, Hubungi Admin!']);
        }

        $cart = Cart::all();
        if (empty($cart)) {
            return redirect()->route('cart.index')->with(['error' => 'Cart Kosong']);
        }
        $payment = Payment::all();
        $total = 0;
        $weight = 0;
        foreach ($cart as $item) {
            $total = $total + ($item->total * $item->product->harga_jual);
            $weight = $weight + ($item->product->berat * $item->total);
        }

        $origin = $this->company->kota_id;
        $destination = auth()->user()->kota_id;

        if (empty($origin) || empty($destination)) {
            return redirect()->route('cart.index')->with(['error' => 'Data tidak lengkap']);
        }

        $response = Http::withHeaders([
            'key' => $key
        ])->post($url . "/cost", [
            'origin'        => $origin,
            'destination'   => $destination,
            'weight'        => $weight,
            'courier'       => $request->courier
        ]);
        if ($response->successful()) {
            $data = $response->json();
            return view('cart.checkout', compact(['data', 'total', 'weight', 'payment']))->with(['company' => $this->company, 'title' => $this->title]);
        } else {
            return redirect()->route('cart.index')->with(['error' => 'Error System, Hubungi Admin!']);
        }
    }


    function checkoutSave(Request $request)
    {
        $this->validate($request, [
            'courier'   => 'required|in:jne,pos,tiki',
            'service'   => 'required',
            'ongkir'    => 'required|integer',
            'payment'   => 'required|integer|exists:payments,id',
        ]);

        $cart = Cart::all();
        $total = 0;
        $weight = 0;
        foreach ($cart as $item) {
            $total = $total + ($item->total * $item->product->harga_jual);
            $weight = $weight + ($item->product->berat * $item->total);
        }
        $order = Order::create([
            'number'            => 1,
            'date'              => date('Y-m-d H:i:s'),
            'total'             => $total,
            'ongkir'            => $request->ongkir,
            'user_id'           => auth()->id(),
            'payment_id'        => $request->payment,
            'receipt_name'      => auth()->user()->ship_name ?? '',
            'receipt_telp'      => auth()->user()->ship_telp ?? '',
            'receipt_address'   => auth()->user()->address ?? '',
            'courir'            => $request->courier,
            'service'           => $request->service,
        ]);

        foreach ($cart as $item) {
            OrderDetail::create([
                'order_id'      => $order->id,
                'product_id'    => $item->product_id,
                'price'         => $item->product->harga_jual ?? 0,
                'qty'           => $item->total,
                'desc'          => $item->desc,
            ]);
            $item->product->update([
                'stock' => $item->product->stock - $item->total,
            ]);
            $item->delete();
        }
        if ($order) {
            return redirect()->route('order.index')->with(['success' => 'Order berhasil dibuat']);
        } else {
            return redirect()->route('order.index')->with(['error' => 'Order gagal dibuat']);
        }
    }
}
