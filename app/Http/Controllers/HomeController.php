<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Kategori;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    function cek(Request $request)
    {
        $this->validate($request, [
            'weight' => 'required|integer|gt:0',
            'courier' => 'required|in:pos,jne,tiki'
        ]);
        $origin = $this->company->kota_id;
        $destination = auth()->user()->kota_id;

        if (empty($origin) || empty($destination)) {
            return response()->json('Data tidak lengkap', 400);
        }

        $response = Http::withHeaders([
            'key' => "4b92274fb285061ec830c70cb4fcaedb"
        ])->post("https://api.rajaongkir.com/starter/cost", [
            'origin'        => $origin,
            'destination'   => $destination,
            'weight'        => $request->weight,
            'courier'       => $request->courier
        ]);

        $data = $response->json()['rajaongkir']['results'];
        return response()->json($data);
    }
}
