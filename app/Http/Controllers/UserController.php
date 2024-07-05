<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User
            ::select()
            ->with('roles')
            ->where("name", "LIKE", "%$request->cari%")
            ->orWhere("username", "LIKE", "%$request->cari%")
            ->paginate(10);
        $roles = Role::select("roles.name")->get();
        $cari = $request->cari;

        return view('admin.user', compact('users', 'cari', 'roles'));
    }
    public function edit(Request $request)
    {
        $user = User
            ::select()
            ->with('roles')
            ->where("id", $request->id)
            ->first();
        $user->role = $user->roles->first()->name;
        $roles = Role::select("roles.name")->get();

        return view('admin.edit_user', compact('user', 'roles'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => ['required', 'string'],
                'name' => ['required', 'string'],
                'password' => ['required'],
                'role' => ['required', 'string'],
            ],
            [
                'required' => 'Input :attribute dibutuhkan.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator, 'user')->withInput();
        }

        $data = $validator->validated();

        $cek_username = User::where('username', $data['username'])->exists();
        if ($cek_username) {
            Session::flash("message", "Username sudah ada!");
            Session::flash("alert", "error");
            return redirect()->back();
        }

        $user = new User();
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->password = Hash::make($data['password']);
        $user->save();

        $user->assignRole($data['role']);

        Session::flash("message", "Data berhasil dibuat!");
        Session::flash("alert", "success");
        return redirect()->back();
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => ['required', 'string'],
                'name' => ['required', 'string'],
                'password' => [],
                'role' => ['required', 'string'],
            ],
            [
                'required' => 'Input :attribute dibutuhkan.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator, 'user')->withInput();
        }

        $data = $validator->validated();

        $user = User::where('id', $request->id)->first();
        $user->name = $data['name'];
        $user->username = $data['username'];
        if (isset($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        $user->syncRoles([$data['role']]);

        Session::flash("message", "Data berhasil diupdate!");
        Session::flash("alert", "success");
        return redirect()->route('user.index');
    }
    public function destroy(Request $request)
    {
        try {
            $user = User::where("id", $request->id)->first();
            $user->delete();

            Session::flash("message", "User berhasil dihapus!");
            Session::flash("alert", "success");
            return redirect()->back();
        } catch (QueryException $e) {
            Session::flash("message", "User sudah berelasi dengan data lain!");
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

        $members = User
            ::select()
            ->withCount(['pemesanan' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('status', 'dibayar');
            }])
            ->whereHas('roles', function ($query) {
                $query->where('name', 'user');
            })
            ->where(function ($query) use ($request) {
                $query->orWhere('users.name', 'LIKE', "%$request->cari%");
            })
            ->having('pemesanan_count', '>=', 5)
            ->paginate(10);
        return view('admin.laporan_member', compact(
            'members',
            'filter',
            'minggu',
            'bulan',
            'tahun',
        ));
    }

    public function download(Request $request)
    {
        $user = User::where('id', $request->id)->first();

        // Membuat instance gambar
        $img = ImageManager::gd()->read('images/kartu_member.png');

        // Menambahkan teks ke dalam gambar
        $img->text(strtoupper($user->name), 195, 285, function (FontFactory $font) {
            $font->filename(public_path('/fonts/Roboto/Roboto-Bold.ttf'));
            $font->size(32);
            $font->color('fff');
            $font->lineHeight(1.6);
            $font->angle(0);
        });

        // Menyimpan gambar yang telah diubah
        $img->save(public_path('images/kartu_member.png'));

        return response()->download(public_path('images/kartu_member.png'))->deleteFileAfterSend();
    }
}
