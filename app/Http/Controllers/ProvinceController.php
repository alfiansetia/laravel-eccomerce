<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    private $title = 'Province';
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
        $data = Province::all();
        return view('province.data', compact('data'))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('province.create')->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:25|min:3|unique:provinces,name',
        ]);
        $province = Province::create([
            'name'      => $request->name,
        ]);
        if ($province) {
            return redirect()->route('province.index')->with(['success' => 'Success Insert Data']);
        } else {
            return redirect()->route('province.index')->with(['error' => 'Failed Insert Data']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Province $province)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        if (!$province) {
            abort(404);
        }
        $data = $province;
        return view('province.edit', compact('data'))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Province $province)
    {
        if (!$province) {
            abort(404);
        }
        $this->validate($request, [
            'name'      => 'required|max:25|min:3|unique:provinces,name,' . $province->id,
        ]);
        $province = $province->update([
            'name'      => $request->name,
        ]);
        if ($province) {
            return redirect()->route('province.index')->with(['success' => 'Success Update Data']);
        } else {
            return redirect()->route('province.index')->with(['error' => 'Failed Update Data']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        if (!$province) {
            abort(404);
        }
        $province = $province->delete();
        if ($province) {
            return redirect()->route('province.index')->with(['success' => 'Success Delete Data']);
        } else {
            return redirect()->route('province.index')->with(['error' => 'Failed Delete Data']);
        }
    }
}
