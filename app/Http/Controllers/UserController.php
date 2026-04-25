<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function customer()
    {
        $customer = User::whereHas('role', function($q){
            $q->where('role_name', 'customer');
        })->get();

        return view('pages.customer', compact('customer'));
    }

    public function createCustomer()
    {
        return view('pages.addCustomer');
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required | unique:users,username',
            'email' => 'required',
            'password' => 'required | confirmed | min:8',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 2,
        ]);

        return back()->with('success', 'Customer berhasil dibuat');
    }

    public function editCustomer(User $customer)
    {
        return view('pages.editCustomer', compact('customer'));
    }

    public function updateCustomer(Request $request, User $customer)
    {
        if($request->username == $customer->username){
            return back()->with('info', 'tidak ada update');
        }
        $request->validate([
            'name' => 'required',
            'username' => 'required | unique:users,username',
            'email' => 'required',
            'password' => 'nullable',
        ]);

        $customer->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return back()->with('success', 'Customer berhasil diupdate');
    }

    public function deleteCustomer(User $customer)
    {
        $customer->delete();

        return back()->with('success', 'Customer berhasil dihapus');
    }

    public function profile()
    {
        $profile = Auth::user();

        return view('pages.profile', compact('profile'));
    }

    public function editProfile()
    {
        $customer = auth()->user();
        return view('pages.editProfile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $customer  = auth()->user();

        if($request->username == $customer->username){
            return back()->with('info', 'tidak ada update');
        }
        $request->validate([
            'name' => 'required',
            'username' => 'required | unique:users,username',
            'email' => 'required',
        ]);

        $customer->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Customer berhasil diupdate');
    }

    public function passwordChange()
    {
        $customer = auth()->user();
        return view('pages.passwordChange', compact('customer'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $user = auth()->user();

        if(!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'password lama yang anda masukkan salah');
        }

        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        return back()->with('success', 'password berhasil diubah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
