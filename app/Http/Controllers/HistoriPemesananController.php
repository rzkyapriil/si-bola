<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoriPemesananController extends Controller
{
	public function index()
	{
		$purchaseHistories = Pemesanan::where('user_id', Auth::user()->id)->paginate(10);

		return view('histori_pemesanan', compact('purchaseHistories'));
	}

	public function view(Request $request)
	{
		$purchase = Pemesanan
			::where('pemesanan.id', $request->id)
			->join('paket_foto', 'pemesanan.paket_foto_id', 'paket_foto.id')
			->select(
				'pemesanan.*',
				'paket_foto.foto',
				'paket_foto.nama',
				'paket_foto.jenis',
				'paket_foto.harga',
			)
			->first();

		return view('lihat_histori_pemesanan', compact('purchase'));
	}
}
