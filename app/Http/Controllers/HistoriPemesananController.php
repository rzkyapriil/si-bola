<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class HistoriPemesananController extends Controller
{
	public function index(Request $request)
	{
		$cari = $request->cari;
		$purchaseHistories = Pemesanan
			::where('user_id', Auth::user()->id)
			->where('kode_pemesanan', "LIKE", "%$cari%")
			->orderBy('created_at', 'desc')
			->paginate(10);

		return view('histori_pemesanan', compact('purchaseHistories', 'cari'));
	}

	public function view(Request $request)
	{
		$purchaseHistory = Pemesanan
			::where('pemesanan.id', $request->id)
			->select()
			->first();
		$transfer = Pembayaran::select()->where('pemesanan_id', $request->id)->first();
		$review = Review::where('pemesanan_id', $request->id)->first();

		return view('lihat_histori_pemesanan', compact('purchaseHistory', 'review', 'transfer'));
	}

	public function update(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'status' => ['required', 'string'],
			],
			[
				'required' => 'Input :attribute dibutuhkan.',
				'string' => 'Input :attribute harus berupa text.',
			]
		);

		if ($validator->fails()) {
			return back()->withErrors($validator, 'pemesanan')->withInput();
		}

		$data = $validator->validated();

		if ($data['status'] != 'dibatalkan') {
			Session::flash("message", "Status tidak ditemukan!");
			Session::flash("alert", "error");
			return redirect()->back();
		}

		$pemesanan = Pemesanan::where('id', $request->id)->first();
		$pemesanan->status = $data['status'];
		$pemesanan->save();

		Session::flash("message", "Pemesanan berhasil dibatalkan!");
		Session::flash("alert", "success");
		return redirect()->back();
	}
}
