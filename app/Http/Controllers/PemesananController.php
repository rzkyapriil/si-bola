<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PemesananController extends Controller
{
    public function index()
    {
        $bookings = Pemesanan::select()->paginate(10);

        return view('admin.booking', compact('bookings'));
    }

    public function view(Request $request)
    {
        $booking = Pemesanan
            ::select("pemesanan.*", "pembayaran.bukti_pembayaran")
            ->leftjoin('pembayaran', 'pemesanan.id', 'pembayaran.pemesanan_id')
            ->where('pemesanan.id', $request->id)
            ->first();

        return view('admin.lihat_booking', compact('booking'));
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
            Session::flash("alert", "Error");
            return redirect()->back();
        }

        $midnight = Carbon::parse($data['tanggal'])->addDay()->startOfDay();
        $data['waktu_selesai'] = Carbon::parse($data['tanggal'] . ' ' . $data['waktu_mulai'])->addHours($data['lama_bermain'])->subMinutes(1);

        // waktu tidak boleh melebihi jam 12
        if ($data['waktu_selesai']->greaterThanOrEqualTo($midnight)) {
            Session::flash("message", "Waktu melebihi jam 24:00!");
            Session::flash("alert", "Error");
            return redirect()->back();
        }
        // dd($data['waktu_selesai']);

        $hari_ini = Carbon::now()->format('Y-m-d');
        $start_time = Carbon::parse($data['tanggal'] . ' ' . $data['waktu_mulai'])->format('Y-m-d H:i:s');
        $end_time = Carbon::parse($data['tanggal'] . ' ' . $data['waktu_selesai']->format('H:i:s'))->format('Y-m-d H:i:s');
        // dd($end_time);

        $pemesanan = Pemesanan
            ::where('lapangan', $data['lapangan'])
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
            Session::flash("alert", "Error");
            return redirect()->back();
        }

        dd($pemesanan);

        $harga = 25000;
        $waktu_mulai = Carbon::parse('')->format($data['waktu_mulai']);
        $waktu_selesai = Carbon::parse('')->format($data['waktu_selesai']);
        $data['user_id'] = Auth::user()->id;
        $data['total_harga'] = $harga * ((int)$waktu_selesai - (int)$waktu_mulai);
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
        Session::flash("alert", "Success");

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
        Session::flash("alert", "Success");
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
            Session::flash("alert", "Success");
            return redirect()->route('booking.index');
        } catch (QueryException $e) {
            Session::flash("message", "Data sudah berelasi dengan data lain!");
            Session::flash("alert", "Error");
            return redirect()->back();
        }
    }
}
