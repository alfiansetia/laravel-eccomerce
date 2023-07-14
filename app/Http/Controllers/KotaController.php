<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Kota;
use App\Models\Province;
use Illuminate\Http\Request;

class KotaController extends Controller
{
    private $title = 'Kota';
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
        $data = Kota::with('province')->get();
        return view('kota.data', compact('data'))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $province = Province::all();
        return view('kota.create', compact('province'))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:25|min:3|unique:kotas,name',
            'province'  => 'required|integer|exists:provinces,id',
        ]);
        $kota = Kota::create([
            'name'          => $request->name,
            'province_id'   => $request->province,
        ]);
        if ($kota) {
            return redirect()->route('kota.index')->with(['success' => 'Success Insert Data']);
        } else {
            return redirect()->route('kota.index')->with(['error' => 'Failed Insert Data']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kota $kotum)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kota $kotum)
    {
        if (!$kotum) {
            abort(404);
        }
        $data = $kotum->load('province');
        $province = Province::all();
        return view('kota.edit', compact(['data', 'province']))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kota $kotum)
    {
        if (!$kotum) {
            abort(404);
        }
        $this->validate($request, [
            'name'      => 'required|max:25|min:3|unique:kotas,name,' . $kotum->id,
            'province'  => 'required|integer|exists:provinces,id',
        ]);
        $kotum = $kotum->update([
            'name'          => $request->name,
            'province_id'   => $request->province,
        ]);
        if ($kotum) {
            return redirect()->route('kota.index')->with(['success' => 'Success Update Data']);
        } else {
            return redirect()->route('kota.index')->with(['error' => 'Failed Update Data']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kota $kotum)
    {
        if (!$kotum) {
            abort(404);
        }
        $kotum = $kotum->delete();
        if ($kotum) {
            return redirect()->route('kota.index')->with(['success' => 'Success Delete Data']);
        } else {
            return redirect()->route('kota.index')->with(['error' => 'Failed Delete Data']);
        }
    }
}
