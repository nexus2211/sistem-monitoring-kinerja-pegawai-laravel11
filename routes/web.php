<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('layout.app');
});


Route::get('/register', [AuthController::class, 'registerView'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login/submit', [AuthController::class, 'loginSubmit'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::controller(PegawaiController::class)->group(function () {

    // PEGAWAI ROUTE
    Route::get('/pegawai','PegawaiIndex')->name('pegawai');
    Route::get('/pegawai/tambah','PegawaitampilTambah')->name('pegawai.tambah');
    Route::post('/pegawai/tambah','PegawaiStore')->name('pegawai.post');
    Route::get('/pegawai/edit/{id}', 'PegawaiEdit')->name('pegawai.edit');
    Route::put('/pegawai/edit/{id}', 'PegawaiUpdate')->name('pegawai.update');
    Route::delete('/pegawai/{id}','PegawaiDelete')->name('pegawai.delete');

    // JABATAN ROUTE
    Route::get('/jabatan','JabatanIndex')->name('jabatan');
    Route::post('/jabatan','JabatanStore')->name('jabatan.post');
    Route::delete('/jabatan/{id}','JabatanDelete')->name('jabatan.delete');
    Route::get('/jabatan/edit/{id}','JabatanEdit')->name('jabatan.edit');
    Route::put('/jabatan/edit/{id}','JabatanUpdate')->name('jabatan.update');

    // BAGIAN ROUTE
    Route::get('/bagian','BagianIndex')->name('bagian');
    Route::post('/bagian','BagianStore')->name('bagian.post');
    Route::delete('/bagian/{id}','BagianDelete')->name('bagian.delete');
    Route::get('/bagian/edit/{id}','BagianEdit')->name('bagian.edit');
    Route::put('/bagian/edit/{id}','BagianUpdate')->name('bagian.update');

});


// Route::get('/pegawai', [PegawaiController::class, 'PegawaiIndex'])->name('pegawai');
// Route::get('/pegawai/tambah', [PegawaiController::class, 'PegawaitampilTambah'])->name('pegawai.tambah');
// Route::post('/pegawai/tambah', [PegawaiController::class, 'PegawaiStore'])->name('pegawai.post');
// Route::get('/pegawai/edit/{id}', [PegawaiController::class, 'PegawaiEdit'])->name('pegawai.edit');
// Route::put('/pegawai/edit/{id}', [PegawaiController::class, 'PegawaiUpdate'])->name('pegawai.update');
// Route::delete('/pegawai/{id}', [PegawaiController::class, 'PegawaiDelete'])->name('pegawai.delete');