<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $title = 'Order';
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
        $data = Order::all();
        return view('order.data', compact('data'))->with(['company' => $this->company, 'title' => $this->title]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if (!$order) {
            abort(404);
        }
        $data =  $order->load('order_detail');
        return view('order.detail', compact(['data']))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        if (!$order) {
            abort(404);
        }
        $data =  $order->load('order_detail');
        return view('order.edit', compact(['data']))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        if (!$order) {
            abort(404);
        }
        $this->validate($request, [
            'ongkir'            => 'required|integer|gte:0',
            'receipt_name'      => 'required|max:30|min:3',
            'receipt_telp'      => 'required|max:15|min:8',
            'receipt_address'   => 'required|max:150|min:5',
        ]);
        $order = $order->update([
            'ongkir'            => $request->ongkir,
            'receipt_name'      => $request->receipt_name,
            'receipt_telp'      => $request->receipt_telp,
            'receipt_address'   => $request->receipt_address,
        ]);
        if ($order) {
            return redirect()->route('order.index')->with(['success' => 'Success Update Data']);
        } else {
            return redirect()->route('order.index')->with(['error' => 'Failed Update Data']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        if (!$order) {
            abort(404);
        }
        $order = $order->delete();
        if ($order) {
            return redirect()->route('order.index')->with(['success' => 'Success Delete Data']);
        } else {
            return redirect()->route('order.index')->with(['error' => 'Failed Delete Data']);
        }
    }

    public function set(Request $request, Order $order)
    {
        if (!$order) {
            abort(404);
        }
        $this->validate($request, [
            'type' => 'required|in:confirm_payment,confirm_process,confirm_sent,confirm_done,confirm_cancel'
        ]);
        switch ($request->type) {
            case 'confirm_payment':
                $order = $order->update([
                    'payment_status' => 'paid',
                ]);
                break;
            case 'confirm_process':
                $order = $order->update([
                    'status' => 'on proccess',
                ]);
                break;
            case 'confirm_sent':
                $order = $order->update([
                    'status' => 'sent',
                ]);
                break;
            case 'confirm_done':
                $order = $order->update([
                    'status' => 'done',
                ]);
                break;
            case 'confirm_cancel':
                $order = $order->update([
                    'status' => 'cancel',
                ]);
                break;
        }
        if ($order) {
            return redirect()->back()->with(['success' => 'Success Confirm Data']);
        } else {
            return redirect()->back()->with(['error' => 'Failed Confirm Data']);
        }
    }
}
