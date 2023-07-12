<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Company;
use Illuminate\Http\Request;

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
        return view('cart.data', compact('data'))->with(['company' => $this->company, 'title' => $this->title]);
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
            'product' => 'required|integer|exists:products,id|unique:carts,product_id,user_id'
        ]);

        $cart = Cart::create([
            'user_id'    => auth()->id(),
            'product_id' => $request->product,
            'total'      => 1,
        ]);
        if ($cart) {
            return redirect()->back()->with(['success' => 'Success Insert Data']);
        } else {
            return redirect()->back()->with(['error' => 'Failed Insert Data']);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
