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
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Login Berhasil',
                ], 200);
        }

        return response()
            ->json([
                'success' => false,
                'message' => 'ID Card tidak terdaftar',
        ], 200);
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        return redirect()->route('index');
    }
}
