<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $title = 'Payment';
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
        $data = Payment::all();
        return view('payment.data', compact('data'))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payment.create')->with(['company' => $this->company, 'title' => $this->title]);
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
        $payment = Payment::create([
            'name'      => $request->name,
            'telp'      => $request->telp,
            'address'   => $request->address,
        ]);
        if ($payment) {
            return redirect()->route('payment.index')->with(['success' => 'Success Insert Data']);
        } else {
            return redirect()->route('payment.index')->with(['error' => 'Failed Insert Data']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        if (!$payment) {
            abort(404);
        }
        $data = $payment;
        return view('payment.edit', compact('data'))->with(['company' => $this->company, 'title' => $this->title]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        if (!$payment) {
            abort(404);
        }
        $this->validate($request, [
            'name'          => 'required|max:25|min:3|unique:payments,name,' . $payment->id,
            'acc_name'      => 'max:15|nullable',
            'acc_number'    => 'max:100|nullable',
        ]);
        $payment = $payment->update([
            'name'      => $request->name,
            'telp'      => $request->telp,
            'address'   => $request->address,
        ]);
        if ($payment) {
            return redirect()->route('payment.index')->with(['success' => 'Success Update Data']);
        } else {
            return redirect()->route('payment.index')->with(['error' => 'Failed Update Data']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        if (!$payment) {
            abort(404);
        }
        $payment = $payment->delete();
        if ($payment) {
            return redirect()->route('payment.index')->with(['success' => 'Success Delete Data']);
        } else {
            return redirect()->route('payment.index')->with(['error' => 'Failed Delete Data']);
        }
    }
}
