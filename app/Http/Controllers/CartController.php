<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Company;
use App\Models\Kota;
use App\Models\Product;
use Illuminate\Http\Request;
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
}
