<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    private $title = 'Kategori';
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
        $data = Kategori::all();
        return view('kategori.data', compact('data'))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create')->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:25|min:3|unique:kategoris,name',
        ]);
        $kategori = Kategori::create([
            'name'      => $request->name,
        ]);
        if ($kategori) {
            return redirect()->route('kategori.index')->with(['success' => 'Success Insert Data']);
        } else {
            return redirect()->route('kategori.index')->with(['error' => 'Failed Insert Data']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        if (!$kategori) {
            abort(404);
        }
        $data = $kategori;
        return view('kategori.edit', compact('data'))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        if (!$kategori) {
            abort(404);
        }
        $this->validate($request, [
            'name' => 'required|max:25|min:3|unique:kategoris,name,' . $kategori->id,
        ]);
        $kategori = $kategori->update([
            'name' => $request->name,
        ]);
        if ($kategori) {
            return redirect()->route('kategori.index')->with(['success' => 'Success Update Data']);
        } else {
            return redirect()->route('kategori.index')->with(['error' => 'Failed Update Data']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        if (!$kategori) {
            abort(404);
        }
        $kategori = $kategori->delete();
        if ($kategori) {
            return redirect()->route('kategori.index')->with(['success' => 'Success Delete Data']);
        } else {
            return redirect()->route('kategori.index')->with(['error' => 'Failed Delete Data']);
        }
    }
}
