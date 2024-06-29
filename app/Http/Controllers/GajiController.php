<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class GajiController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pegawai_id' => ['required', 'numeric'],
                'tanggal' => ['required', 'date'],
                'gaji' => ['required', 'numeric'],
            ],
            [
                'required' => 'Input :attribute dibutuhkan.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator, 'gaji')->withInput();
        }

        $data = $validator->validated();

        $date = Carbon::parse($data['tanggal']);
        $startDate = $date->startOfMonth()->format('Y-m-d H:i:s');
        $endDate = $date->endOfMonth()->format('Y-m-d H:i:s');

        $check_tanggal = Gaji::where('pegawai_id', $data['pegawai_id'])->whereBetween('tanggal', [$startDate, $endDate])->exists();
        if ($check_tanggal) {
            Session::flash("message", "Pegawai sudah mendapatkan gaji dibulan " . $date->translatedFormat('F') . "!");
            Session::flash("alert", "error");
            return redirect()->back();
        }

        $salary = new Gaji();
        $salary->pegawai_id = $data['pegawai_id'];
        $salary->tanggal = $data['tanggal'];
        $salary->gaji = $data['gaji'];
        $salary->save();

        Session::flash("message", "Pegawai berhasil digaji!");
        Session::flash("alert", "success");
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        try {
            $salary = Gaji::where("id", $request->id)->first();
            $salary->delete();

            Session::flash("message", "Gaji berhasil dihapus!");
            Session::flash("alert", "success");
            return redirect()->back();
        } catch (QueryException $e) {
            Session::flash("message", "Gaji sudah berelasi dengan data lain!");
            Session::flash("alert", "error");
            return redirect()->back();
        }
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

        $finances = Gaji
            ::select("gaji.*", "pegawai.nama", "pegawai.jabatan")
            ->join('pegawai', 'gaji.pegawai_id', 'pegawai.id')
            ->whereBetween('gaji.created_at', [$startDate, $endDate])
            ->paginate(10);

        return view('admin.laporan_keuangan', compact(
            'finances',
            'filter',
            'minggu',
            'bulan',
            'tahun',
        ));
    }
}
