<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $employees = Pegawai
            ::select()
            ->where("nama", "LIKE", "%$request->cari%")
            ->orWhere("jabatan", "LIKE", "%$request->cari%")
            ->paginate(10);
        $cari = $request->cari;

        return view('admin.pegawai', compact('employees', 'cari'));
    }
    public function edit(Request $request)
    {
        $employee = Pegawai
            ::select()
            ->where("id", $request->id)
            ->first();

        return view('admin.edit_pegawai', compact('employee'));
    }
    public function view(Request $request)
    {
        $employee = Pegawai
            ::select()
            ->where("id", $request->id)
            ->first();

        $employee_salaries = Gaji
            ::select()
            ->where("pegawai_id", $request->id)
            ->paginate(10);

        return view('admin.lihat_pegawai', compact('employee', 'employee_salaries'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => ['required', 'string'],
                'jabatan' => ['required', 'string'],
            ],
            [
                'required' => 'Input :attribute dibutuhkan.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator, 'pegawai')->withInput();
        }

        $data = $validator->validated();

        $employee = new Pegawai();
        $employee->nama = $data['nama'];
        $employee->jabatan = $data['jabatan'];
        $employee->save();

        Session::flash("message", "Pegawai berhasil dibuat!");
        Session::flash("alert", "success");
        return redirect()->back();
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => ['required', 'string'],
                'jabatan' => ['required', 'string'],
            ],
            [
                'required' => 'Input :attribute dibutuhkan.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator, 'pegawai')->withInput();
        }

        $data = $validator->validated();

        $employee = Pegawai::where('id', $request->id)->first();
        $employee->nama = $data['nama'];
        $employee->jabatan = $data['jabatan'];
        $employee->save();

        Session::flash("message", "Pegawai berhasil diupdate!");
        Session::flash("alert", "success");
        return redirect()->route('pegawai.index');
    }
    public function destroy(Request $request)
    {
        try {

            $gaji = Gaji::where("pegawai_id", $request->id)->get();
            foreach ($gaji as $data_gaji) {
                $data_gaji->delete();
            }
            $employee = Pegawai::where("id", $request->id)->first();
            $employee->delete();

            Session::flash("message", "Pegawai berhasil dihapus!");
            Session::flash("alert", "success");
            return redirect()->back();
        } catch (QueryException $e) {
            Session::flash("message", "Pegawai sudah berelasi dengan data lain!");
            Session::flash("alert", "error");
            return redirect()->back();
        }
    }
}
