<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $hari_ini = Carbon::now()->format('Y-m-d');
        $timetables = Pemesanan
            ::where('status', 'dibayar')
            ->whereDate('tanggal', $request->tanggal == null ? $hari_ini : $request->tanggal)
            ->orderBy('waktu_mulai', 'asc')
            ->select()
            ->get();

        $startTime = Carbon::createFromTime(8, 0);
        $endTime = Carbon::createFromTime(24, 0);

        return view('home', compact('timetables', 'startTime', 'endTime'));
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function form()
    {
        if (Auth::user()) {
            return view('booking');
        }

        return redirect()->route('home.index');
    }
}
