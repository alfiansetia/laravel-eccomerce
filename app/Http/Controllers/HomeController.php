<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Kategori;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $title = 'Home';
    private $company;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->company = Company::first();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data = Product::query();
        if ($request->filled('kategori')) {
            $data->whereRelation('kategori', 'name', 'like', "%$request->kategori%");
        }
        $product = $data->paginate(6);
        $kategori = Kategori::all();
        $last = Product::latest()->first();
        return view('home', compact(['product', 'kategori', 'last']))->with(['company' => $this->company, 'title' => $this->title]);
    }
}
