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
}
