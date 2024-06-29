<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = isset($request->tahun) ? $request->tahun : Carbon::now()->format('Y');

        $date = Carbon::createFromFormat('Y', $tahun);
        $startDate = $date->startOfYear()->format('Y-m-d H:i:s');
        $endDate = $date->endOfYear()->format('Y-m-d H:i:s');

        $bookings = Pemesanan
            ::select()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->paginate(10);

        $total_booking = Pemesanan::whereBetween('created_at', [$startDate, $endDate])->count();
        $total_booking_selesai = Pemesanan::whereBetween('created_at', [$startDate, $endDate])->where('status', 'dibayar')->count();
        $menunggu_konfirmasi = Pemesanan::whereBetween('created_at', [$startDate, $endDate])->where('status', 'menunggu konfirmasi')->count();

        return view('admin.dashboard', compact(
            'bookings',
            'tahun',
            'total_booking',
            'total_booking_selesai',
            'menunggu_konfirmasi',
        ));
    }
}
