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
Route::post("/user/register", [\App\Http\Controllers\UserAuthController::class, "store"])->name("user.store");
Route::delete("/user/logout", [\App\Http\Controllers\UserAuthController::class, "logout"])->name("user.logout");

Route::middleware("auth")->group(function () {
    Route::get("/booking", [\App\Http\Controllers\HomeController::class, "form"])->name("home.booking");
    Route::post("/booking", [\App\Http\Controllers\PemesananController::class, "store"])->name("booking.store");
    Route::get("/histori-pemesanan", [\App\Http\Controllers\HistoriPemesananController::class, "index"])->name("histori-pemesanan.index");
    Route::get("/pembayaran", [\App\Http\Controllers\PembayaranController::class, "view"])->name("pembayaran.view");
    Route::post("/pembayaran", [\App\Http\Controllers\PembayaranController::class, "store"])->name("pembayaran.store");
});

Route::prefix('admin')->middleware(["auth", "admin"])->group(function () {
    Route::get("/dashboard", [\App\Http\Controllers\DashboardController::class, "index"])->name("dashboard.index");

    Route::get("/booking", [\App\Http\Controllers\PemesananController::class, "index"])->name("booking.index");
    Route::get("/booking/{id}/view", [\App\Http\Controllers\PemesananController::class, "view"])->name("booking.view");
    Route::put("/booking/{id}", [\App\Http\Controllers\PemesananController::class, "update"])->name("booking.update");
    Route::delete("/booking/{id}", [\App\Http\Controllers\PemesananController::class, "destroy"])->name("booking.destroy");
});
