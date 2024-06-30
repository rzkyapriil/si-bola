<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $inventories = Inventaris
            ::select()
            ->where("nama", "LIKE", "%$request->cari%")
            ->paginate(10);
        $cari = $request->cari;

        return view('admin.inventaris', compact('inventories', 'cari'));
    }
    public function edit(Request $request)
    {
        $inventory = Inventaris
            ::select()
            ->where("id", $request->id)
            ->first();

        return view('admin.edit_inventaris', compact('inventory'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'foto' => ['required', 'image', 'mimes:jpeg,png,jpg'],
                'nama' => ['required', 'string'],
                'harga' => ['required', 'numeric'],
                'status' => ['required', 'string'],
            ],
            [
                'required' => 'Input :attribute dibutuhkan.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator, 'inventaris')->withInput();
        }

        $data = $validator->validated();

        $angka = Inventaris::select()->count();
        $fileName = 'INVENTARIS-' . time() . '.' . $data['foto']->getClientOriginalExtension();
        $path = $data['foto']->storeAs("images/inventaris", $fileName, "public");

        $inventory = new Inventaris();
        $inventory->foto = "/storage/" . $path;
        $inventory->nama = $data['nama'];
        $inventory->harga = $data['harga'];
        $inventory->status = $data['status'];
        $inventory->save();

        Session::flash("message", "Inventaris berhasil ditambahkan!");
        Session::flash("alert", "success");
        return redirect()->back();
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'foto' => ['image', 'mimes:jpeg,png,jpg'],
                'nama' => ['required', 'string'],
                'harga' => ['required', 'numeric'],
                'status' => ['required', 'string'],
            ],
            [
                'required' => 'Input :attribute dibutuhkan.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator, 'inventaris')->withInput();
        }

        $data = $validator->validated();

        $inventory = Inventaris::where('id', $request->id)->first();

        if (!isset($data['foto'])) {
            $inventory->nama = $data['nama'];
            $inventory->harga = $data['harga'];
            $inventory->status = $data['status'];
            $inventory->save();

            Session::flash("message", "Inventaris berhasil diperbaharui!");
            Session::flash("alert", "success");
            return redirect()->route("inventaris.index");
        }

        $filePath = str_replace("/storage/", "public/", $inventory->foto);
        if (Storage::disk('local')->exists($filePath)) {
            Storage::disk('local')->delete($filePath);
        }

        $fileName = 'INVENTARIS-' . time() . '.' . $data['foto']->getClientOriginalExtension();
        $path = $data['foto']->storeAs("images/inventaris", $fileName, "public");
        $inventory->foto = "/storage/" . $path;
        $inventory->nama = $data['nama'];
        $inventory->harga = $data['harga'];
        $inventory->status = $data['status'];
        $inventory->save();

        Session::flash("message", "Inventaris berhasil diperbaharui!");
        Session::flash("alert", "success");
        return redirect()->route('inventaris.index');
    }
    public function destroy(Request $request)
    {
        try {
            $inventory = Inventaris::where("id", $request->id)->first();
            $filePath = str_replace("/storage/", "public/", $inventory->foto);
            if (Storage::disk('local')->exists($filePath)) {
                Storage::disk('local')->delete($filePath);
            }
            $inventory->delete();

            Session::flash("message", "Inventaris berhasil dihapus!");
            Session::flash("alert", "success");
            return redirect()->back();
        } catch (QueryException $e) {
            Session::flash("message", "Inventaris sudah berelasi dengan data lain!");
            Session::flash("alert", "error");
            return redirect()->back();
        }
    }
}
