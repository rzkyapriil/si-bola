<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
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
            ->orderBy('lapangan', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->select()
            ->get();
        $inventories = Inventaris::select()->get();
        $startTime = Carbon::createFromTime(8, 0);
        $endTime = Carbon::createFromTime(24, 0);
        $tanggal = isset($request->tanggal) ? $request->tanggal : Carbon::now()->format('Y-m-d');

        return view('home', compact('timetables', 'inventories', 'startTime', 'endTime', 'tanggal'));
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function syaratDanKetentuan()
    {
        return view('snk_member');
    }

    public function form()
    {
        if (Auth::user()) {
            return view('booking');
        }

        return redirect()->route('home.index');
    }
}
