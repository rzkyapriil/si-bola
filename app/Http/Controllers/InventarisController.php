<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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

        $inventory = new Inventaris();
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
        $inventory->nama = $data['nama'];
        $inventory->harga = $data['harga'];
        $inventory->status = $data['status'];
        $inventory->save();

        Session::flash("message", "Inventaris berhasil diupdate!");
        Session::flash("alert", "success");
        return redirect()->route('inventaris.index');
    }
    public function destroy(Request $request)
    {
        try {
            $inventory = Inventaris::where("id", $request->id)->first();
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
