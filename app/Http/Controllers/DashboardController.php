<?php

namespace App\Http\Controllers;

use App\Models\TblUser;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function cardDashboard()
    {
        // untuk role
        $user = Auth::user();
        $user = TblUser::where('username', $user->username)
            ->get('id_role');
        return view('dashboard.card-dashboard');
    }
}
