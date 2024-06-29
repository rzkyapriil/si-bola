<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    function view(Request $request)
    {
        $payments = Pemesanan
            ::select()
            ->where("user_id", Auth::user()->id)
            ->where("kode_pemesanan", urldecode($request->kode_pemesanan))
            ->where('status', 'Belum dibayar')->first();

        // dd($payments);

        if (!isset($payments)) {
            return redirect()->route('home.index');
        }

        return view("pembayaran", compact('payments'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'metode_pembayaran' => ['required', 'string'],
                'bukti_pembayaran' => ['image', 'mimes:jpeg,png,jpg'],
                'kode_pemesanan' => ['required', 'string'],
            ],
            [
                'required' => 'Input :attribute dibutuhkan.',
                'images' => 'Input :attribute harus merupakan gambar.',
                'mimes' => 'Input :attribute harus berformat :mimes.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator, 'pembayaran')->withInput();
        }

        $data = $validator->validated();

        $pemesanan = Pemesanan::where('kode_pemesanan', $data['kode_pemesanan'])->first();

        if ($data['metode_pembayaran'] == 'cash') {
            $pembayaran = new Pembayaran();
            $pembayaran->pemesanan_id = $pemesanan->id;
            $pembayaran->metode_pembayaran = $data['metode_pembayaran'];
            $pembayaran->bukti_pembayaran = null;
            $pembayaran->save();
        } else {
            $fileName = "BP-" . str_replace('/', '-', $pemesanan->kode_pemesanan) . '.' . $data["bukti_pembayaran"]->getClientOriginalExtension();
            $path = $data["bukti_pembayaran"]->storeAs("images/bukti-pembayaran", $fileName, "public");

            $pembayaran = new Pembayaran();
            $pembayaran->pemesanan_id = $pemesanan->id;
            $pembayaran->metode_pembayaran = $data['metode_pembayaran'];
            $pembayaran->bukti_pembayaran = "/storage/" . $path;
            $pembayaran->save();
        }

        $pemesanan->status = 'menunggu konfirmasi';
        $pemesanan->save();

        Session::flash("message", "Data berhasil ditambahkan!");
        Session::flash("alert", "success");
        return redirect()->route('home.index');
    }

    public function laporan(Request $request)
    {
        $filter = $request->filter;
        $minggu = $request->minggu;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        if ($filter == 'perminggu') {
            $date = Carbon::parse($minggu);
            $startDate = $date->startOfWeek()->format('Y-m-d H:i:s');
            $endDate = $date->endOfWeek()->format('Y-m-d H:i:s');
        } elseif ($filter == 'perbulan') {
            $date = Carbon::parse($bulan);
            $startDate = $date->startOfMonth()->format('Y-m-d H:i:s');
            $endDate = $date->endOfMonth()->format('Y-m-d H:i:s');
        } elseif ($filter == 'pertahun') {
            $date = Carbon::createFromFormat('Y', $tahun);
            $startDate = $date->startOfYear()->format('Y-m-d H:i:s');
            $endDate = $date->endOfYear()->format('Y-m-d H:i:s');
        } else {
            $date = Carbon::now();
            $startDate = $date->startOfYear()->format('Y-m-d H:i:s');
            $endDate = $date->endOfYear()->format('Y-m-d H:i:s');
        }

        $payments = Pembayaran
            ::select(
                "pembayaran.*",
                "users.name as nama_user",
                "pemesanan.kode_pemesanan",
                "pemesanan.total_harga"
            )
            ->join('pemesanan', 'pembayaran.pemesanan_id', 'pemesanan.id')
            ->join('users', 'pemesanan.user_id', 'users.id')
            ->whereBetween('pembayaran.created_at', [$startDate, $endDate])
            ->where('pemesanan.status', 'dibayar')
            ->paginate(10);

        return view('admin.laporan_pembayaran', compact(
            'payments',
            'filter',
            'minggu',
            'bulan',
            'tahun',
        ));
    }
}
