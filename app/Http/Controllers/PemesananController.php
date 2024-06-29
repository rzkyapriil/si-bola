<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PemesananController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->cari;
        $bookings = Pemesanan
            ::select()
            ->where('kode_pemesanan', "LIKE", "%$cari%")
            ->paginate(10);

        return view('admin.booking', compact('bookings', 'cari'));
    }

    public function view(Request $request)
    {
        $booking = Pemesanan
            ::select("pemesanan.*", "pembayaran.bukti_pembayaran")
            ->leftjoin('pembayaran', 'pemesanan.id', 'pembayaran.pemesanan_id')
            ->where('pemesanan.id', $request->id)
            ->first();

        $review = Review::where('pemesanan_id', $request->id)->first();

        return view('admin.lihat_booking', compact('booking', 'review'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => ['required', 'string'],
                'tanggal' => ['required', 'date'],
                'lapangan' => ['required', 'string'],
                'waktu_mulai' => ['required', 'date_format:H:i'],
                'lama_bermain' => ['required'],
            ],
            [
                'required' => 'Input :attribute dibutuhkan.',
                'max' => 'Input :attribute tidak boleh lebih dari :max.',
                'numeric' => 'Input :attribute harus berupa angka.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator, 'pemesanan')->withInput();
        }


        $data = $validator->validated();

        $hari_ini = Carbon::today();
        $check_tanggal = Carbon::parse($data['tanggal']);

        if ($check_tanggal->lessThan($hari_ini)) {
            Session::flash("message", "Tanggal tidak boleh dibawah dari " . $hari_ini->translatedFormat('d F Y'));
            Session::flash("alert", "error");
            return redirect()->back();
        }

        $midnight = Carbon::parse($data['tanggal'])->addDay()->startOfDay();
        $data['waktu_selesai'] = Carbon::parse($data['tanggal'] . ' ' . $data['waktu_mulai'])->addHours($data['lama_bermain'])->subMinutes(1);

        // waktu tidak boleh melebihi jam 12
        if ($data['waktu_selesai']->greaterThanOrEqualTo($midnight)) {
            Session::flash("message", "Waktu melebihi jam 24:00!");
            Session::flash("alert", "error");
            return redirect()->back();
        }

        $jam_buka = Carbon::parse("08:00");
        $waktu_mulai = Carbon::parse($data['tanggal'] . ' ' . $data['waktu_mulai']);
        // waktu tidak boleh kurang dari jam buka
        if ($waktu_mulai->lessThan($jam_buka)) {
            Session::flash("message", "Waktu kurang dari jam 08:00!");
            Session::flash("alert", "error");
            return redirect()->back();
        }

        $hari_ini = Carbon::now()->format('Y-m-d');
        $start_time = Carbon::parse($data['tanggal'] . ' ' . $data['waktu_mulai'])->format('Y-m-d H:i:s');
        $end_time = Carbon::parse($data['tanggal'] . ' ' . $data['waktu_selesai']->format('H:i:s'))->format('Y-m-d H:i:s');

        $pemesanan = Pemesanan
            ::where('lapangan', $data['lapangan'])
            ->where('tanggal', $data['tanggal'])
            ->where(function ($query) use ($start_time, $end_time) {
                $query->where(function ($query) use ($start_time, $end_time) {
                    $query->where('waktu_mulai', '<=', $start_time)
                        ->where('waktu_selesai', '>=', $start_time);
                })
                    ->orWhere(function ($query) use ($start_time, $end_time) {
                        $query->where('waktu_mulai', '<=', $end_time)
                            ->where('waktu_selesai', '>=', $end_time);
                    })
                    ->orWhere(function ($query) use ($start_time, $end_time) {
                        $query->where('waktu_mulai', '>=', $start_time)
                            ->where('waktu_selesai', '<=', $end_time);
                    });
            })
            ->exists();

        // check pemesanan apakah ada yang sama jamnya
        if ($pemesanan) {
            Session::flash("message", "Jadwal lapangan sudah ada!");
            Session::flash("alert", "error");
            return redirect()->back();
        }

        $harga = 50000;
        $data['user_id'] = Auth::user()->id;
        $check_member = User::select()
            ->with(['pemesanan' => function ($query) {
                $query->where('pemesanan.status', 'dibayar');
            }])
            ->first();

        if ($check_member->pemesanan->count() >= 5) {
            $data['total_harga'] = ($harga * $data['lama_bermain']) - ((($harga * $data['lama_bermain']) * 20) / 100);
        } else {
            $data['total_harga'] = $harga * $data['lama_bermain'];
        }
        $data['status'] = 'belum dibayar';
        $tanggal = Carbon::now();
        $pemesanan_ke = Pemesanan::whereDate('created_at', $tanggal->format('Y-m-d'))->count();

        // dd($data);
        $pemesanan = new Pemesanan();
        $pemesanan->user_id = $data['user_id'];
        $pemesanan->kode_pemesanan = 'BOO/' . $tanggal->format('Ymd') . '/KE/' . str_pad($pemesanan_ke + 1, 6, '0', STR_PAD_LEFT);;
        $pemesanan->nama = $data['nama'];
        $pemesanan->tanggal = $data['tanggal'];
        $pemesanan->lapangan = $data['lapangan'];
        $pemesanan->waktu_mulai = $data['waktu_mulai'];
        $pemesanan->waktu_selesai = $data['waktu_selesai'];
        $pemesanan->total_harga = $data['total_harga'];
        $pemesanan->status = $data['status'];
        $pemesanan->save();

        Session::flash("message", "Booking berhasil dibuat!");
        Session::flash("alert", "success");

        return redirect()->route('pembayaran.view', ['kode_pemesanan' => urlencode($pemesanan->kode_pemesanan)]);
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

        $pemesanan = Pemesanan::where('id', $request->id)->first();
        $pemesanan->status = $data['status'];
        $pemesanan->save();

        Session::flash("message", "Status berhasil diupdate!");
        Session::flash("alert", "success");
        return redirect()->route('booking.index');
    }

    public function destroy(Request $request)
    {
        try {
            $pembayaran = Pembayaran::where("pemesanan_id", $request->id)->first();
            $pemesanan = Pemesanan::where("id", $request->id)->first();

            if (isset($pembayaran)) {
                $filePath = str_replace("/storage/", "public/", $pembayaran->bukti_pembayaran);
                if (Storage::disk('local')->exists($filePath)) {
                    Storage::disk('local')->delete($filePath);
                }

                $pembayaran->delete();
            }

            $pemesanan->delete();

            Session::flash("message", "Booking berhasil dihapus!");
            Session::flash("alert", "success");
            return redirect()->route('booking.index');
        } catch (QueryException $e) {
            Session::flash("message", "Data sudah berelasi dengan data lain!");
            Session::flash("alert", "error");
            return redirect()->back();
        }
    }

    public function laporan(Request $request)
    {
        $filter = $request->filter;
        $status = isset($request->status) ? $request->status : 'dibayar';
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

        $purchases = Pemesanan
            ::select()
            ->where('status', $status)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->paginate(10);

        return view('admin.laporan_pemesanan', compact(
            'purchases',
            'filter',
            'status',
            'minggu',
            'bulan',
            'tahun',
        ));
    }
}
