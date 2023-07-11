<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CompanyController extends Controller
{
    protected $company;

    public function __construct()
    {
        $this->company = Company::first();
    }

    public function general()
    {
        return view('company.general')->with(['company' => $this->company, 'title' => 'General Setting']);
    }

    public function generalUpdate(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:30',
            'telp'      => 'required|max:15',
            'address'   => 'required|max:200',
        ]);
        $update = $this->company->update([
            'name'      => $request->name,
            'telp'      => $request->telp,
            'address'   => $request->address,
        ]);
        if ($update) {
            return redirect()->route('company.general')->with('success', 'Success Update Data!');
        } else {
            return redirect()->route('company.general')->with('error', 'Failed Update Data!');
        }
    }

    public function social()
    {
        return view('company.social')->with(['company' => $this->company, 'title' => 'Social Setting']);
    }

    public function socialUpdate(Request $request)
    {
        $this->validate($request, [
            'wa'        => 'required|max:15',
            'fb'        => 'max:15|nullable',
            'ig'        => 'max:15|nullable',
        ]);
        $update = $this->company->update([
            'wa'        => $request->wa,
            'fb'        => $request->fb,
            'ig'        => $request->ig,
        ]);
        if ($update) {
            return redirect()->route('company.social')->with('success', 'Success Update Data!');
        } else {
            return redirect()->route('company.social')->with('error', 'Failed Update Data!');
        }
    }

    public function image()
    {
        return view('company.image')->with(['company' => $this->company, 'title' => 'Image Setting']);
    }

    public function imageUpdate(Request $request)
    {
        $this->validate($request, [
            'logo'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'fav'       => 'required|image|mimes:png,jpg|max:1024',
        ]);
        $logo = $this->company->logo;
        $fav = $this->company->fav;
        if ($files = $request->file('logo')) {
            File::delete('images/company/' . $logo);
            $destinationPath = 'images/company/'; // upload path
            $logo = 'logo.' . $files->getClientOriginalExtension();
            $files->move($destinationPath, $logo);
        }
        if ($files = $request->file('fav')) {
            File::delete('images/company/' . $fav);
            $destinationPath = 'images/company/'; // upload path
            $fav = 'favicon.' . $files->getClientOriginalExtension();
            $files->move($destinationPath, $fav);
        }
        $update = $this->company->update([
            'logo'      => $logo,
            'fav'       => $fav,
        ]);
        if ($update) {
            return redirect()->route('company.image')->with('success', 'Success Update Data!');
        } else {
            return redirect()->route('company.image')->with('error', 'Failed Update Data!');
        }
    }

    public function other()
    {
        return view('company.other')->with(['company' => $this->company, 'title' => 'Other Setting']);
    }

    public function otherUpdate(Request $request)
    {
        $this->validate($request, [
            'footer_struk'  => 'required|max:100',
            'tax'           => 'required|in:yes,no',
        ]);
        $update = $this->company->update([
            'footer_struk'  => $request->footer_struk,
            'tax'           => $request->tax,
        ]);
        if ($update) {
            return redirect()->route('company.other')->with('success', 'Success Update Data!');
        } else {
            return redirect()->route('company.other')->with('error', 'Failed Update Data!');
        }
    }
}
