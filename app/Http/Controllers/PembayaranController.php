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
                'bukti_pembayaran' => ['required', 'image', 'mimes:jpeg,png,jpg'],
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

        $tanggal = Carbon::now()->parse()->format('Y-m-d');
        $fileName = "BP-" . str_replace('/', '-', $pemesanan->kode_pemesanan) . '.' . $data["bukti_pembayaran"]->getClientOriginalExtension();
        $path = $data["bukti_pembayaran"]->storeAs("images/bukti-pembayaran", $fileName, "public");

        $pembayaran = new Pembayaran();
        $pembayaran->pemesanan_id = $pemesanan->id;
        $pembayaran->bukti_pembayaran = "/storage/" . $path;
        $pembayaran->save();

        $pemesanan->status = 'menunggu konfirmasi';
        $pemesanan->save();

        Session::flash("message", "Data berhasil ditambahkan!");
        Session::flash("alert", "success");
        return redirect()->route('home.index');
    }
}
