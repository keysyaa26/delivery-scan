<?php

namespace App\Http\Controllers;

use App\Models\TblUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
        ]);

        // cari user
        $user = TblUser::where('username', $request->username)->first();

        if ($user) {
            Auth::login($user);
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Username tidak terdaftar!');
    }

    public function destroy(Request $request)
    {
        // Hapus session
        if ($request->session()->has('customer')) {
            $request->session()->forget(['customer', 'plan', 'cycle']);
        }
        Auth::logout();
        return redirect()->route('index');
    }
}
