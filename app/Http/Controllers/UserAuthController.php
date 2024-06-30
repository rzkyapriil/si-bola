<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserAuthController extends Controller
{
	public function login(UserLoginRequest $request)
	{
		$data = $request->validated();
		$user = User::where("username", $data["username"])->first();
		if (
			$user &&
			Auth::attempt([
				"username" => $data["username"],
				"password" => $data["password"],
			])
		) {
			$user->token = Str::uuid()->tostring();
			$user->save();

			if ($user->hasRole('admin') or $user->hasRole('pegawai')) {
				Session::flash("message", "Anda berhasil login!");
				Session::flash("alert", "success");
				return redirect()->route("dashboard.index");
			} elseif ($user->hasRole('kepala gor')) {
				Session::flash("message", "Anda berhasil login!");
				Session::flash("alert", "success");
				return redirect()->route("laporan.pemesanan");
			}

			Session::flash("message", "Anda berhasil login!");
			Session::flash("alert", "success");
			return redirect()->route("home.index");
		} else {
			Session::flash("message", "Username atau password salah!");
			Session::flash("alert", "error");
			return redirect()->back();
		}
	}

	public function register(UserRegisterRequest $request)
	{
		$data = $request->validated();

		if (user::where("username", $data["username"])->count() == 1) {
			Session::flash("message", "Username sudah digunakan!");
			Session::flash("alert", "error");
			return redirect()->route("home.index");
		}

		$user = new user($data);
		$user->password = Hash::make($data["password"]);
		$user->save();

		$user->assignRole('user');

		Session::flash("message", "User berhasil diregistrasi!");
		Session::flash("alert", "success");
		return redirect()->route("login.index");
	}

	public function logout()
	{
		$user = Auth::user();
		$user->token = null;
		$user->save();

		Session::flush();
		auth::logout();

		Session::flash("message", "Anda berhasil logout!");
		Session::flash("alert", "success");
		return redirect()->route("home.index");
	}
}
