<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Penyewaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PenyewaanController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->cari;
        $rentals = Penyewaan
            ::select('penyewaan.*', 'inventaris.nama')
            ->join('inventaris', 'penyewaan.inventaris_id', 'inventaris.id')
            ->where('inventaris.nama', "LIKE", "%$cari%")
            ->paginate(10);

        return view('admin.penyewaan', compact('rentals', 'cari'));
    }
    public function list(Request $request)
    {
        $cari = $request->cari;
        $rentals = Penyewaan
            ::select('penyewaan.*', 'inventaris.nama')
            ->join('inventaris', 'penyewaan.inventaris_id', 'inventaris.id')
            // ->where('kode_pemesanan', "LIKE", "%$cari%")
            ->where('user_id', Auth::user()->id)
            ->orderBy('penyewaan.created_at', 'desc')
            ->paginate(10);

        return view('histori_penyewaan', compact('rentals', 'cari'));
    }
    public function form(Request $request)
    {
        if (Auth::user()) {
            $inventaris = $request->inventaris;
            $inventories = Inventaris::select()->get();
            return view('penyewaan', compact('inventories', 'inventaris'));
        }

        return redirect()->route('home.index');
    }
    function view(Request $request)
    {
        $rental = Penyewaan
            ::select('penyewaan.*', 'inventaris.nama')
            ->join('inventaris', 'penyewaan.inventaris_id', 'inventaris.id')
            ->where("penyewaan.user_id", Auth::user()->id)
            ->where("penyewaan.penyewaan_id", $request->penyewaan)
            ->where('penyewaan.status', 'Belum dibayar')->first();

        if (!isset($rental)) {
            return redirect()->route('home.index');
        }

        return view("pembayaran_penyewaan", compact('rental'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'inventaris' => ['required', 'numeric'],
                'tanggal' => ['required', 'date'],
                'lama_penyewaan' => ['required'],
            ],
            [
                'required' => 'Input :attribute dibutuhkan.',
                'max' => 'Input :attribute tidak boleh lebih dari :max.',
                'numeric' => 'Input :attribute harus berupa angka.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator, 'penyewaan')->withInput();
        }

        $data = $validator->validated();
        // dd($data);

        $hari_ini = Carbon::today();
        $check_tanggal = Carbon::parse($data['tanggal']);

        if ($check_tanggal->lessThan($hari_ini)) {
            Session::flash("message", "Tanggal tidak boleh dibawah dari " . $hari_ini->translatedFormat('d F Y'));
            Session::flash("alert", "error");
            return redirect()->back();
        }

        $midnight = Carbon::parse($data['tanggal'])->addDay()->startOfDay();
        $data['tanggal_selesai'] = Carbon::parse($data['tanggal'])->addHours($data['lama_penyewaan'])->subMinutes(1);

        // waktu tidak boleh melebihi jam 12
        if ($data['tanggal_selesai']->greaterThanOrEqualTo($midnight)) {
            Session::flash("message", "Waktu melebihi jam 24:00!");
            Session::flash("alert", "error");
            return redirect()->back();
        }

        $jam_buka = Carbon::parse("08:00");
        $tanggal_mulai = Carbon::parse($data['tanggal']);
        // waktu tidak boleh kurang dari jam buka
        if ($tanggal_mulai->lessThan($jam_buka)) {
            Session::flash("message", "Waktu kurang dari jam 08:00!");
            Session::flash("alert", "error");
            return redirect()->back();
        }

        $hari_ini = Carbon::now()->format('Y-m-d');
        $start_time = Carbon::parse($data['tanggal'])->format('Y-m-d H:i:s');
        $end_time = Carbon::parse($data['tanggal_selesai'])->format('Y-m-d H:i:s');

        $penyewaan = Penyewaan
            ::where('inventaris_id', $data['inventaris'])
            ->where('status', '!=', 'dibatalkan')
            ->where(function ($query) use ($start_time, $end_time) {
                $query->where(function ($query) use ($start_time, $end_time) {
                    $query->where('tanggal_mulai', '<=', $start_time)
                        ->where('tanggal_selesai', '>=', $start_time);
                })
                    ->orWhere(function ($query) use ($start_time, $end_time) {
                        $query->where('tanggal_mulai', '<=', $end_time)
                            ->where('tanggal_selesai', '>=', $end_time);
                    })
                    ->orWhere(function ($query) use ($start_time, $end_time) {
                        $query->where('tanggal_mulai', '>=', $start_time)
                            ->where('tanggal_selesai', '<=', $end_time);
                    });
            })
            ->exists();

        // check pemesanan apakah ada yang sama jamnya
        if ($penyewaan) {
            Session::flash("message", "Penyewaan sudah ada!");
            Session::flash("alert", "error");
            return redirect()->back();
        }

        $harga = 25000;
        $data['user_id'] = Auth::user()->id;
        // $check_member = User::select()
        //     ->where('id', $data['user_id'])
        //     ->with(['pemesanan' => function ($query) {
        //         $query->where('pemesanan.status', 'dibayar');
        //     }])
        //     ->first();

        // if ($check_member->pemesanan->count() >= 5) {
        //     $data['total_harga'] = ($harga * $data['lama_bermain']) - ((($harga * $data['lama_bermain']) * 20) / 100);
        // } else {
        // }
        $data['total_harga'] = $harga * $data['lama_penyewaan'];
        $data['status'] = 'belum dibayar';

        // dd($data);
        $penyewaan = new Penyewaan();
        $penyewaan->user_id = $data['user_id'];
        $penyewaan->inventaris_id = $data['inventaris'];
        $penyewaan->tanggal_mulai = $data['tanggal'];
        $penyewaan->tanggal_selesai = $data['tanggal_selesai'];
        $penyewaan->total_harga = $data['total_harga'];
        $penyewaan->status = $data['status'];
        $penyewaan->save();

        Session::flash("message", "Penyewaan berhasil dibuat!");
        Session::flash("alert", "success");

        return redirect()->route('penyewaan.view', ['penyewaan' => $penyewaan->penyewaan_id]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'metode_pembayaran' => ['string'],
                'bukti_pembayaran' => ['image', 'mimes:jpeg,png,jpg'],
                'status' => ['string'],
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

        $penyewaan = Penyewaan::where('penyewaan_id', $request->id)->first();

        if ($data['status'] == 'menunggu konfirmasi') {
            if ($data['metode_pembayaran'] == 'cash') {
                $penyewaan->metode_pembayaran = $data['metode_pembayaran'];
                $penyewaan->bukti_pembayaran = null;
            } else {
                $fileName = "BP-PENYEWAAN-" . $penyewaan->penyewaan_id . '.' . $data["bukti_pembayaran"]->getClientOriginalExtension();
                $path = $data["bukti_pembayaran"]->storeAs("images/bukti-pembayaran", $fileName, "public");

                $penyewaan->metode_pembayaran = $data['metode_pembayaran'];
                $penyewaan->bukti_pembayaran = "/storage/" . $path;
            }

            $penyewaan->status = 'menunggu konfirmasi';
            $penyewaan->save();
            Session::flash("message", "Pembayaran berhasil! silahkan tunggu dikonfirmasi");
            Session::flash("alert", "success");
            return redirect()->route('home.index');
        } elseif ($data['status'] == 'dibatalkan' or $data['status'] == 'dibayar') {
            $penyewaan->status = $data['status'];
            $penyewaan->save();
            Session::flash("message", "Penyewaan berhasil dibatalkan!");
            Session::flash("alert", "success");
            return redirect()->back();
        } else {
            Session::flash("message", "Status tidak ditemukan!");
            Session::flash("alert", "success");
            return redirect()->back();
        }
    }
}
