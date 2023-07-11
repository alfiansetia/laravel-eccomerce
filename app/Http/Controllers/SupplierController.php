<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private $title = 'Supplier';
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
        $data = Supplier::all();
        return view('supplier.data', compact('data'))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create')->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:25|min:3|unique:suppliers,name',
            'telp'      => 'max:15|nullable',
            'address'   => 'max:100|nullable',
        ]);
        $supplier = Supplier::create([
            'name'      => $request->name,
            'telp'      => $request->telp,
            'address'   => $request->address,
        ]);
        if ($supplier) {
            return redirect()->route('supplier.index')->with(['success' => 'Success Insert Data']);
        } else {
            return redirect()->route('supplier.index')->with(['error' => 'Failed Insert Data']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        if (!$supplier) {
            abort(404);
        }
        $data = $supplier;
        return view('supplier.edit', compact('data'))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        if (!$supplier) {
            abort(404);
        }
        $this->validate($request, [
            'name'      => 'required|max:25|min:3|unique:suppliers,name,' . $supplier->id,
            'telp'      => 'max:15|nullable',
            'address'   => 'max:100|nullable',
        ]);
        $supplier = $supplier->update([
            'name'      => $request->name,
            'telp'      => $request->telp,
            'address'   => $request->address,
        ]);
        if ($supplier) {
            return redirect()->route('supplier.index')->with(['success' => 'Success Update Data']);
        } else {
            return redirect()->route('supplier.index')->with(['error' => 'Failed Update Data']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        if (!$supplier) {
            abort(404);
        }
        $supplier = $supplier->delete();
        if ($supplier) {
            return redirect()->route('supplier.index')->with(['success' => 'Success Delete Data']);
        } else {
            return redirect()->route('supplier.index')->with(['error' => 'Failed Delete Data']);
        }
    }
}
