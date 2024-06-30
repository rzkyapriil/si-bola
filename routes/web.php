<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", [\App\Http\Controllers\HomeController::class, "index"])->name("home.index");
Route::get("/booking", [\App\Http\Controllers\HomeController::class, "form"])->name("booking.index");
Route::get("/login", [\App\Http\Controllers\HomeController::class, "login"])->name("login.index");
Route::get("/register", [\App\Http\Controllers\HomeController::class, "register"])->name("register.index");

Route::post("/user/login", [\App\Http\Controllers\UserAuthController::class, "login"])->name("user.login");
Route::post("/user/register", [\App\Http\Controllers\UserAuthController::class, "register"])->name("user.register");
Route::delete("/user/logout", [\App\Http\Controllers\UserAuthController::class, "logout"])->name("user.logout");

Route::middleware(["auth", "role:user"])->group(function () {
    Route::get("/booking", [\App\Http\Controllers\HomeController::class, "form"])->name("home.booking");
    Route::post("/booking", [\App\Http\Controllers\PemesananController::class, "store"])->name("booking.store");

    Route::get("/histori-pemesanan", [\App\Http\Controllers\HistoriPemesananController::class, "index"])->name("histori-pemesanan.index");
    Route::get("/histori-pemesanan/{id}", [\App\Http\Controllers\HistoriPemesananController::class, "view"])->name("histori-pemesanan.view");
    Route::put("/histori-pemesanan/{id}", [\App\Http\Controllers\HistoriPemesananController::class, "update"])->name("histori-pemesanan.update");

    Route::post("/review", [\App\Http\Controllers\ReviewController::class, "store"])->name("review.store");

    Route::get("/pembayaran", [\App\Http\Controllers\PembayaranController::class, "view"])->name("pembayaran.view");
    Route::post("/pembayaran", [\App\Http\Controllers\PembayaranController::class, "store"])->name("pembayaran.store");
});

Route::prefix('admin')->middleware(["auth"])->group(function () {
    Route::get("/dashboard", [\App\Http\Controllers\DashboardController::class, "index"])->middleware(['role:admin|pegawai'])->name("dashboard.index");

    Route::prefix('booking')->name("booking")->middleware(['role:pegawai'])->group(function () {
        Route::get("/", [\App\Http\Controllers\PemesananController::class, "index"])->name(".index");
        Route::get("/{id}/view", [\App\Http\Controllers\PemesananController::class, "view"])->name(".view");
        Route::put("/{id}", [\App\Http\Controllers\PemesananController::class, "update"])->name(".update");
        Route::delete("/{id}", [\App\Http\Controllers\PemesananController::class, "destroy"])->name(".destroy");
    });

    Route::prefix('user')->name("user")->middleware(['role:admin'])->group(function () {
        Route::get("/", [\App\Http\Controllers\UserController::class, "index"])->name(".index");
        Route::post("/", [\App\Http\Controllers\UserController::class, "store"])->name(".store");
        Route::get("/{id}/edit", [\App\Http\Controllers\UserController::class, "edit"])->name(".edit");
        Route::put("/{id}", [\App\Http\Controllers\UserController::class, "update"])->name(".update");
        Route::delete("/{id}", [\App\Http\Controllers\UserController::class, "destroy"])->name(".destroy");
    });

    Route::prefix('pegawai')->name("pegawai")->middleware(['role:admin'])->group(function () {
        Route::get("/", [\App\Http\Controllers\PegawaiController::class, "index"])->name(".index");
        Route::post("/", [\App\Http\Controllers\PegawaiController::class, "store"])->name(".store");
        Route::get("/{id}", [\App\Http\Controllers\PegawaiController::class, "view"])->name(".view");
        Route::get("/{id}/edit", [\App\Http\Controllers\PegawaiController::class, "edit"])->name(".edit");
        Route::put("/{id}", [\App\Http\Controllers\PegawaiController::class, "update"])->name(".update");
        Route::delete("/{id}", [\App\Http\Controllers\PegawaiController::class, "destroy"])->name(".destroy");
    });

    Route::prefix('inventaris')->name("inventaris")->middleware(['role:pegawai'])->group(function () {
        Route::get("/", [\App\Http\Controllers\InventarisController::class, "index"])->name(".index");
        Route::post("/", [\App\Http\Controllers\InventarisController::class, "store"])->name(".store");
        Route::get("/{id}/edit", [\App\Http\Controllers\InventarisController::class, "edit"])->name(".edit");
        Route::put("/{id}", [\App\Http\Controllers\InventarisController::class, "update"])->name(".update");
        Route::delete("/{id}", [\App\Http\Controllers\InventarisController::class, "destroy"])->name(".destroy");
    });

    Route::prefix('gaji')->name("gaji")->group(function () {
        Route::post("/", [\App\Http\Controllers\GajiController::class, "store"])->name(".store");
        Route::delete("/{id}", [\App\Http\Controllers\GajiController::class, "destroy"])->name(".destroy");
    });

    Route::prefix('laporan')->name("laporan")->middleware(['role:admin'])->group(function () {
        Route::get("/member", [\App\Http\Controllers\UserController::class, "laporan"])->name(".member");
        Route::get("/keuangan", [\App\Http\Controllers\GajiController::class, "laporan"])->name(".keuangan");
    });

    Route::prefix('laporan')->name("laporan")->middleware(['role:kepala gor|admin'])->group(function () {
        Route::get("/pemesanan", [\App\Http\Controllers\PemesananController::class, "laporan"])->name(".pemesanan");
        Route::get("/pembayaran", [\App\Http\Controllers\PembayaranController::class, "laporan"])->name(".pembayaran");
    });
});
