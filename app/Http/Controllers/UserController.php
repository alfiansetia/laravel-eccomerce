<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    private $title = 'User';
    private $company;

    public function __construct()
    {
        $this->company = Company::first();
    }

    public function index()
    {
        $data = User::all();
        return view('user.data', compact('data'))->with(['company' => $this->company, 'title' => $this->title]);
    }

    public function show(User $user)
    {
        abort(404);
    }

    public function create()
    {
        return view('user.create')->with(['company' => $this->company, 'title' => $this->title]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:25|min:3',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:5',
            'wa'        => 'required|max:15',
            'role'      => 'required|in:admin,user',
        ]);
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'wa'        => $request->wa,
        ]);
        if ($user) {
            return redirect()->route('user.index')->with(['success' => 'Success Insert Data']);
        } else {
            return redirect()->route('user.index')->with(['error' => 'Failed Insert Data']);
        }
    }

    public function edit(User $user)
    {
        if (!$user) {
            abort(404);
        }
        $data = $user;
        return view('user.edit', compact('data'))->with(['company' => $this->company, 'title' => $this->title]);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'      => 'required|max:25|min:3',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'min:5|nullable',
            'wa'        => 'required|max:15',
            'role'      => 'required|in:admin,user',
        ]);
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        $user = $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'wa'        => $request->wa,
        ]);
        if ($user) {
            return redirect()->route('user.index')->with(['success' => 'Success Update Data']);
        } else {
            return redirect()->route('user.index')->with(['error' => 'Failed Update Data']);
        }
    }

    public function destroy(User $user)
    {
        if (!$user) {
            abort(404);
        }
        $user = $user->delete();
        if ($user) {
            return redirect()->route('user.index')->with(['success' => 'Success Delete Data']);
        } else {
            return redirect()->route('user.index')->with(['error' => 'Failed Delete Data']);
        }
    }

    public function profile()
    {
        return view('user.profile')->with(['company' => $this->company, 'title' => 'Profile Setting']);
    }

    public function profileUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $this->validate($request, [
            'name'      => 'required|max:25|min:3',
            'wa'        => 'required|max:15|min:8',
            'address'   => 'max:150',
        ]);
        $update = $user->update([
            'name'      => $request->name,
            'wa'        => $request->wa,
            'address'   => $request->address,
        ]);
        if ($update) {
            return redirect()->route('user.profile')->with('success', 'Success Update Profile!');
        } else {
            return redirect()->route('user.profile')->with('error', 'Failed Update Profile!');
        }
    }

    public function password()
    {
        return view('user.password')->with(['company' => $this->company, 'title' => 'Password Setting']);
    }

    public function passwordUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $this->validate($request, [
            'password'  => ['required', 'same:password2', Password::min(8)->numbers()],
            'password2' => 'required',
        ]);
        if (Hash::check($request->password, $user->password)) {
            return redirect()->route('user.password')->with(['error' => "Password tidak boleh sama dengan sebelumnya!"]);
        } else {
            $password = $user->update([
                'password'     => Hash::make($request->password),
            ]);
            if ($password) {
                return redirect()->route('user.profile')->with(['success' => 'Success Update Password!']);
            } else {
                return redirect()->route('user.profile')->with(['error' => 'Failed Update Password!']);
            }
        }
    }
}
