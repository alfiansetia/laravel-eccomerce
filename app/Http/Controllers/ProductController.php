<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Kategori;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    private $title = 'Product';
    private $company;

    public function __construct()
    {
        $this->company = Company::first();
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::all();
        return view('product.data', compact('data'))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supplier = Supplier::all();
        $kategori = Kategori::all();
        return view('product.create', compact(['supplier', 'kategori']))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:25|min:3|unique:products,name',
            'kategori'  => 'integer|exists:kategoris,id',
            'supplier'  => 'integer|exists:suppliers,id',
            'harga_beli' => 'required|integer|gte:0',
            'harga_jual' => 'required|integer|gte:0',
            'berat'     => 'required|integer|gte:0',
            'stock'     => 'required|integer|gte:0',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'desc'      => 'max:100|nullable',
        ]);
        $img = null;
        if ($files = $request->file('image')) {
            $destinationPath = 'images/products/';
            $img = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $img);
        }
        $product = Product::create([
            'name'          => $request->name,
            'kategori_id'   => $request->kategori,
            'supplier_id'   => $request->supplier,
            'harga_beli'    => $request->harga_beli,
            'harga_jual'    => $request->harga_jual,
            'berat'         => $request->berat,
            'stock'         => $request->stock,
            'image'         => $img,
            'desc'          => $request->desc,
        ]);
        if ($product) {
            return redirect()->route('product.index')->with(['success' => 'Success Insert Data']);
        } else {
            return redirect()->route('product.index')->with(['error' => 'Failed Insert Data']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if (!$product) {
            abort(404);
        }
        $data = $product;
        $supplier = Supplier::all();
        $kategori = Kategori::all();
        return view('product.edit', compact(['data', 'kategori', 'supplier']))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if (!$product) {
            abort(404);
        }
        $this->validate($request, [
            'name'      => 'required|max:25|min:3|unique:products,name,' . $product->id,
            'kategori'  => 'integer|exists:kategoris,id',
            'supplier'  => 'integer|exists:suppliers,id',
            'harga_beli' => 'required|integer|gte:0',
            'harga_jual' => 'required|integer|gte:0',
            'berat'     => 'required|integer|gte:0',
            'stock'     => 'required|integer|gte:0',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'desc'      => 'max:100|nullable',
        ]);
        $img = $product->getRawOriginal('image');
        if ($files = $request->file('image')) {
            File::delete('images/products/' . $img);
            $destinationPath = 'images/products/';
            $img = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $img);
        }
        $product = $product->update([
            'name'          => $request->name,
            'kategori_id'   => $request->kategori,
            'supplier_id'   => $request->supplier,
            'harga_beli'    => $request->harga_beli,
            'harga_jual'    => $request->harga_jual,
            'berat'         => $request->berat,
            'stock'         => $request->stock,
            'image'         => $img,
            'desc'          => $request->desc,
        ]);
        if ($product) {
            return redirect()->route('product.index')->with(['success' => 'Success Update Data']);
        } else {
            return redirect()->route('product.index')->with(['error' => 'Failed Update Data']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (!$product) {
            abort(404);
        }
        if ($product->getRawOriginal('image')) {
            File::delete('images/products/' . $product->getRawOriginal('image'));
        }
        $product = $product->delete();
        if ($product) {
            return redirect()->route('product.index')->with(['success' => 'Success Delete Data']);
        } else {
            return redirect()->route('product.index')->with(['error' => 'Failed Delete Data']);
        }
    }
}
